<?php

namespace App\Http\Controllers\ActiveDirectory;

use Adldap\Contracts\AdldapInterface;
use Adldap\Exceptions\ModelNotFoundException;
use Adldap\Models\User as AdldapUser;
use App\Http\Controllers\Controller;
use App\Http\Presenters\ActiveDirectory\ForgotPasswordPresenter;
use App\Http\Requests\ActiveDirectory\ForgotPassword\DiscoverRequest;
use App\Http\Requests\ActiveDirectory\ForgotPassword\PasswordRequest;
use App\Http\Requests\ActiveDirectory\ForgotPassword\QuestionRequest;
use App\Jobs\Com\User\ChangePassword;
use App\Models\User;
use Illuminate\Contracts\Encryption\Encrypter;

class ForgotPasswordController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var AdldapInterface
     */
    protected $adldap;

    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @var ForgotPasswordPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param User                    $user
     * @param AdldapInterface         $adldap
     * @param Encrypter               $encrypter
     * @param ForgotPasswordPresenter $presenter
     */
    public function __construct(User $user, AdldapInterface $adldap, Encrypter $encrypter, ForgotPasswordPresenter $presenter)
    {
        $this->user = $user;
        $this->adldap = $adldap;
        $this->encrypter = $encrypter;
        $this->presenter = $presenter;
    }

    /**
     * Displays the form to reset a users password.
     *
     * @return \Illuminate\View\View
     */
    public function discover()
    {
        $form = $this->presenter->form();

        return view('pages.forgot-password.discover', compact('form'));
    }

    /**
     * Discovers and creates a forgot password
     * token for the submitted username.
     *
     * @param DiscoverRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function find(DiscoverRequest $request)
    {
        try {
            $profile = $this->adldap
                ->getDefaultProvider()
                ->search()
                ->users()
                ->findOrFail($request->input('username'));

            // Retrieve the user that has 3 or more security questions.
            $user = $this->user
                ->where('email', $profile->getEmail())
                ->has('questions', '>=', 3)
                ->first();

            // Check that we've retrieved a user from the query.
            if ($user instanceof User) {
                $token = $user->generateForgotToken();

                return redirect()->route('auth.forgot-password.questions', [$token]);
            }

            $message = "Unfortunately this account hasn't finished their forgot password setup.";

            flash()->setTimer(false)->error('Error', $message);
        } catch (ModelNotFoundException $e) {
            $message = "We couldn't locate the user you're looking for. Try again!";

            flash()->setTimer(false)->error('Error', $message);
        }

        return redirect()->route('auth.forgot-password.discover');
    }

    /**
     * Displays the form for answering the users security questions.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function questions($token = '')
    {
        $user = $this->user->locateByForgotToken($token);

        if ($user instanceof User) {
            $form = $this->presenter->formQuestions($user);

            return view('pages.forgot-password.questions', compact('form'));
        }

        return redirect()->route('auth.forgot-password.discover');
    }

    /**
     * Processes the submitted question answers and generates
     * a reset token if all answers are correct.
     *
     * @param QuestionRequest $request
     * @param string          $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function answer(QuestionRequest $request, $token)
    {
        $user = $this->user->locateByForgotToken($token);

        if ($user instanceof User) {
            // Get the submitted question answers.
            $answers = $request->input('questions', []);

            // Get the question IDs.
            $ids = array_keys($answers);

            // Try to retrieve all the users questions.
            $questions = $user->questions()->find($ids);

            // The number of correct answers.
            $correct = 0;

            // Go through each found question attached to the user.
            foreach ($questions as $question) {
                // We'll retrieve the actual answer the user gave during setup and decrypt it.
                $actual = $this->encrypter->decrypt($question->pivot->answer);

                // We'll retrieve the answer we've been given for the current question.
                $given = $answers[$question->id];

                // Make sure the given answer is identical to he actual answer.
                if ($given === $actual) {
                    $correct++;
                }
            }

            // Check that the amount of correct answers equals the amount of questions found.
            if ($correct === count($questions)) {
                // If all answers are correct, we'll generate the
                // reset token for the user and return it.
                $reset = $user->generateResetToken();

                return redirect()->route('auth.forgot-password.reset', [$reset]);
            }
        }

        $message = 'Hmmm, it looks there was an issue with one of your answers. Try again!';

        flash()->setTimer(null)->error('Error', $message);

        return redirect()->route('auth.forgot-password.questions', [$token])->withInput($request->all());
    }

    /**
     * Displays the form for resetting a users password by the specified token.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reset($token)
    {
        $user = $this->user->locateByResetToken($token);

        if ($user instanceof User) {
            $form = $this->presenter->formReset($user);

            return view('pages.forgot-password.reset', compact('form'));
        }

        return redirect()->route('auth.forgot-password.discover');
    }

    /**
     * Changes the users password by the specified token.
     *
     * @param PasswordRequest $request
     * @param string          $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(PasswordRequest $request, $token)
    {
        $user = $this->user->locateByResetToken($token);

        $profile = $this->adldap
            ->getDefaultProvider()
            ->search()
            ->users()
            ->where(['mail' => $user->email])
            ->first();

        if ($user instanceof User && $profile instanceof AdldapUser) {
            $job = new ChangePassword($profile, $request->input('password'));

            $changed = $this->dispatch($job);

            if ($changed) {
                $user->clearForgotToken();
                $user->clearResetToken();

                flash()->success('Success!', 'Successfully changed password. You can now login with your new password.');

                return redirect()->route('auth.login.index');
            }

            return $changed;
        }

        flash()->error('Error!', 'There was an issue changing your password. Please try again.');

        return redirect()->route('auth.forgot-password.reset', [$token]);
    }
}
