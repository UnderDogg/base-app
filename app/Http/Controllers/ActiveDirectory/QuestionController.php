<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActiveDirectory\QuestionRequest;
use App\Processors\ActiveDirectory\QuestionProcessor;

class QuestionController extends Controller
{
    /**
     * @var QuestionProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param QuestionProcessor $processor
     */
    public function __construct(QuestionProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all active directory security questions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new security question.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new security question.
     *
     * @param QuestionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created message.');

            return redirect()->route('active-directory.questions.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a security question. Please try again.');

            return redirect()->route('active-directory.questions.index');
        }
    }

    /**
     * Displays the form for editing the specified security question.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified security question.
     *
     * @param QuestionRequest $request
     * @param int|string      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully created message.');

            return redirect()->route('active-directory.questions.index');
        } else {
            flash()->error('Error!', 'There was an issue editing this question. Please try again.');

            return redirect()->route('active-directory.questions.edit', [$id]);
        }
    }

    /**
     * Deletes the specified security question.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted question.');

            return redirect()->route('active-directory.questions.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this question. Please try again.');

            return redirect()->route('active-directory.questions.edit', [$id]);
        }
    }

    /**
     * Creates default security questions.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function seed()
    {
        if ($this->processor->seed()) {
            flash()->success('Success!', 'Successfully created questions.');

            return redirect()->route('active-directory.questions.index');
        } else {
            flash()->error('Error!', 'There was an issue creating questions. Please try again.');

            return redirect()->route('active-directory.questions.index');
        }
    }
}
