<?php

namespace App\Processors\Com;

use COM;
use Adldap\Models\User as AdldapUser;
use Adldap\Contracts\Adldap;
use App\Models\User;
use App\Http\Requests\Com\QuestionRequest;
use App\Http\Requests\Com\DiscoverRequest;
use App\Http\Presenters\Com\ForgotPasswordPresenter;
use App\Processors\Processor;
use Illuminate\Contracts\Encryption\Encrypter;

class ForgotPasswordProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Adldap
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
     * @var COM
     */
    protected $com;

    /**
     * The COM command to execute.
     *
     * @var string
     */
    protected $command = 'LDAP:';

    /**
     * Constructor.
     *
     * @param User                    $user
     * @param Adldap                  $adldap
     * @param Encrypter               $encrypter
     * @param ForgotPasswordPresenter $presenter
     */
    public function __construct(User $user, Adldap $adldap, Encrypter $encrypter, ForgotPasswordPresenter $presenter)
    {
        $this->user = $user;
        $this->adldap = $adldap;
        $this->encrypter = $encrypter;
        $this->presenter = $presenter;
        $this->com = new COM($this->command);
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
     *
     *
     * @param DiscoverRequest $request
     *
     * @return bool
     */
    public function find(DiscoverRequest $request)
    {
        $profile = $this->adldap->users()->find($request->input('username'));

        if ($profile instanceof AdldapUser) {
            // Retrieve the user that has 3 or more security questions.
            $user = $this->user
                ->where('email', $profile->getEmail())
                ->has('questions', '>=', 3)
                ->first();

            // Check that we've retrieved a user from the query.
            if ($user instanceof User) {
                return $user->generateForgotToken();
            }
        }

        return false;
    }

    /**
     * Displays a form of all of the users security questions.
     *
     * @param string $token
     *
     * @return bool|\Illuminate\View\View
     */
    public function questions($token)
    {
        $user = $this->user->locateByForgotToken($token);

        if ($user instanceof User) {
            $form = $this->presenter->formQuestions($user);

            return view('pages.forgot-password.questions', compact('form'));
        }

        return false;
    }

    public function reset(QuestionRequest $request, $token)
    {
        $user = $this->user->locateByForgotToken($token);

        if ($user instanceof User) {
            $answers = $request->input('questions', []);

            $ids = array_keys($answers);

            $questions = $user->questions()->find($ids);

            // Go through each found question attached to the user.
            foreach ($questions as $question) {
                // We'll retrieve the actual answer the user gave during setup and decrypt it.
                $actual = $this->encrypter->decrypt($question->pivot->answer);

                // We'll retrieve the answer we've been given for the current question.
                $given = $answers[$question->getKey()];

                // Make sure the given answer is identical to he actual answer.
                if ($given === $actual) {
                    continue;
                }

                break;
            }
        }

        return false;
    }
}
