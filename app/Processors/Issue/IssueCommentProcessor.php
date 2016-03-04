<?php

namespace App\Processors\Issue;

use App\Http\Presenters\Issue\IssueCommentPresenter;
use App\Http\Requests\Issue\IssueCommentRequest;
use App\Jobs\Issue\Comment\Store;
use App\Jobs\Issue\Comment\Update;
use App\Models\Issue;
use App\Policies\IssueCommentPolicy;
use App\Processors\Processor;

class IssueCommentProcessor extends Processor
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var IssueCommentPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Issue                 $issue
     * @param IssueCommentPresenter $presenter
     */
    public function __construct(Issue $issue, IssueCommentPresenter $presenter)
    {
        $this->issue = $issue;
        $this->presenter = $presenter;
    }

    /**
     * Adds a comment to an issue.
     *
     * @param IssueCommentRequest $request
     * @param int|string          $id
     *
     * @return bool|Issue
     */
    public function store(IssueCommentRequest $request, $id)
    {
        /** @var Issue $issue */
        $issue = $this->issue->findOrFail($id);

        if (IssueCommentPolicy::create(auth()->user(), $issue)) {
            return $this->dispatch(new Store($request, $issue));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing a comment.
     *
     * @param int|string $id
     * @param int|string $commentId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $commentId)
    {
        /** @var Issue $issue */
        $issue = $this->issue->findOrFail($id);

        // Find the issue comment.
        $comment = $issue->comments()->findOrFail($commentId);

        // Load it's files.
        $comment->load(['files']);

        if (IssueCommentPolicy::edit(auth()->user(), $issue, $comment)) {
            $form = $this->presenter->form($issue, $comment);

            return view('pages.issues.comments.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates an issue comment.
     *
     * @param IssueCommentRequest $request
     * @param int|string          $id
     * @param int|string          $commentId
     *
     * @return bool
     */
    public function update(IssueCommentRequest $request, $id, $commentId)
    {
        /** @var Issue $issue */
        $issue = $this->issue->findOrFail($id);

        // Retrieve the comment from the issue.
        $comment = $issue->comments()->findOrFail($commentId);

        if (IssueCommentPolicy::edit(auth()->user(), $issue, $comment)) {
            return $this->dispatch(new Update($request, $issue, $comment));
        }

        $this->unauthorized();
    }

    /**
     * Deletes an issue comment.
     *
     * @param int|string $id
     * @param int|string $commentId
     *
     * @return bool
     */
    public function destroy($id, $commentId)
    {
        /** @var Issue $issue */
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssueCommentPolicy::destroy(auth()->user(), $issue, $comment)) {
            $issue->comments()->detach($comment);

            return $comment->delete();
        }

        $this->unauthorized();
    }
}
