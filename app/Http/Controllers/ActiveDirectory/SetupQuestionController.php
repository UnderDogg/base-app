<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Http\Controllers\Controller;
use App\Http\Presenters\ActiveDirectory\SetupQuestionPresenter;
use App\Http\Requests\ActiveDirectory\SetupQuestionRequest;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SetupQuestionController extends Controller
{
    /**
     * @var Question
     */
    protected $question;

    /**
     * @var SetupQuestionPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Question               $question
     * @param SetupQuestionPresenter $presenter
     */
    public function __construct(Question $question, SetupQuestionPresenter $presenter)
    {
        $this->question = $question;
        $this->presenter = $presenter;
    }

    /**
     * Displays all of the users security questions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $finished = (count($user->questions) >= 3 ? true : false);

        $questions = $this->presenter->table($user);

        return view('pages.active-directory.questions.setup.index', compact('questions', 'finished'));
    }

    /**
     * Displays the users security question.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();

        $question = $user->questions()->findOrFail($id);

        $form = $this->presenter->form($user, $question);

        $answer = Crypt::decrypt($question->pivot->answer);

        return view('pages.active-directory.questions.setup.edit', compact('form', 'answer'));
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
        $user = Auth::user();

        $user->questions()->detach([$id]);

        if ($request->persist($user)) {
            flash()->success('Success!', 'Successfully updated security question.');

            return redirect()->route('security-questions.index');
        }

        flash()->error('Error!', 'There was an issue updating this security question. Please try again.');

        return redirect()->route('security-questions.edit', [$id]);
    }

    /**
     * Displays the form to setup security questions.
     *
     * @return \Illuminate\View\View
     */
    public function setup()
    {
        $user = Auth::user();

        $form = $this->presenter->form($user, $this->question);

        // Add one to the question count to indicate
        // the current step is in progress.
        $step = count($user->questions) + 1;

        return view('pages.active-directory.questions.setup.step', compact('form', 'step'));
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
        $user = Auth::user();

        if ($request->persist($user)) {
            flash()->success('Success!', 'Successfully saved security question.');

            return redirect()->back();
        }

        flash()->error('Error!', 'There was an issue saving this security question. Please try again.');

        return redirect()->back();
    }
}
