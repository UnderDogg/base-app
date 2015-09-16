<?php

namespace App\Processors;

use App\Http\Presenters\IssueCommentPresenter;
use App\Http\Requests\IssueCommentRequest;
use App\Models\Issue;

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
        $issue = $this->issue->findOrFail($id);

        return $issue->createComment($request->input('content'));
    }

    /**
     * Displays the form for editing a comment.
     *
     * @param int|string $id
     * @param int|string $commentId
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function edit($id, $commentId)
    {
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        $form = $this->presenter->form($issue, $comment);

        $this->authorize($comment);

        return view('pages.issues.comments.edit', compact('form'));
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
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        $comment->content = $request->input('content', $comment->content);

        return $comment->save();
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
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        $this->authorize($comment);

        $issue->comments()->detach($comment);

        return $comment->delete();
    }
}
