<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Http\Controllers\Controller;
use App\Http\Presenters\ActiveDirectory\SetupQuestionPresenter;
use App\Http\Requests\ActiveDirectory\SetupQuestionRequest;
use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Encryption\Encrypter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetupQuestionController extends Controller
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var Question
     */
    protected $question;

    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @var SetupQuestionPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guard                  $guard
     * @param Question               $question
     * @param Encrypter              $encrypter
     * @param SetupQuestionPresenter $presenter
     */
    public function __construct(Guard $guard, Question $question, Encrypter $encrypter, SetupQuestionPresenter $presenter)
    {
        $this->guard = $guard;
        $this->question = $question;
        $this->encrypter = $encrypter;
        $this->presenter = $presenter;
    }

    /**
     * Displays all of the users security questions.
     *
     * @return \Illuminate\View\View
     *
     * @throws NotFoundHttpException
     */
    public function index()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $finished = (count($user->questions) >= 3 ? true : false);

            $questions = $this->presenter->table($user);

            return view('pages.active-directory.questions.setup.index', compact('questions', 'finished'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Displays the users security question.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     *
     * @throws NotFoundHttpException
     */
    public function edit($id)
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $question = $user->questions()->findOrFail($id);

            $form = $this->presenter->form($user, $question);

            $answer = $this->encrypter->decrypt($question->pivot->answer);

            return view('pages.active-directory.questions.setup.edit', compact('form', 'answer'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Updates the specified security question.
     *
     * @param SetupQuestionRequest $request
     * @param int|string           $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SetupQuestionRequest $request, $id)
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $user->questions()->detach([$id]);

            if ($request->persist($user, $this->encrypter)) {
                flash()->success('Success!', 'Successfully updated security question.');

                return redirect()->route('security-questions.index');
            }
        }

        flash()->error('Error!', 'There was an issue updating this security question. Please try again.');

        return redirect()->route('security-questions.edit', [$id]);
    }

    /**
     * Displays the form to setup security questions.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Illuminate\View\View
     */
    public function setup()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $form = $this->presenter->form($user, $this->question);

            // Add one to the question count to indicate
            // the current step is in progress.
            $step = count($user->questions) + 1;

            return view('pages.active-directory.questions.setup.step', compact('form', 'step'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Saves a users security question.
     *
     * @param SetupQuestionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SetupQuestionRequest $request)
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            if ($request->persist($user, $this->encrypter)) {
                flash()->success('Success!', 'Successfully saved security question.');

                return redirect()->back();
            } else {
                flash()->error('Error!', 'There was an issue saving this security question. Please try again.');

                return redirect()->back();
            }
        }

        throw new NotFoundHttpException();
    }
}
