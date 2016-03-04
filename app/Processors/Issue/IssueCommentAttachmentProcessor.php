<?php

namespace App\Processors\Issue;

use App\Jobs\Attachment\Update;
use App\Http\Requests\AttachmentRequest;
use App\Http\Presenters\Issue\IssueCommentAttachmentPresenter;
use App\Policies\IssueCommentPolicy;
use App\Models\Issue;
use App\Policies\IssuePolicy;
use App\Processors\Processor;

class IssueCommentAttachmentProcessor extends Processor
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var IssueCommentAttachmentPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Issue                           $issue
     * @param IssueCommentAttachmentPresenter $presenter
     */
    public function __construct(Issue $issue, IssueCommentAttachmentPresenter $presenter)
    {
        $this->issue = $issue;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified issue attachment.
     *
     * @param int|string $issueId
     * @param int|string $commentId
     * @param string     $fileUuid
     *
     * @return \Illuminate\View\View
     */
    public function show($issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssuePolicy::show(auth()->user(), $issue)) {
            $file = $comment->findFile($fileUuid);

            return view('pages.issues.comments.attachments.show', compact('issue', 'comment', 'file'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified issue attachment.
     *
     * @param int|string $issueId
     * @param int|string $commentId
     * @param string     $fileUuid
     *
     * @return \Illuminate\View\View
     */
    public function edit($issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssueCommentPolicy::edit(auth()->user(), $issue, $comment)) {
            $file = $comment->findFile($fileUuid);

            $form = $this->presenter->form($issue, $comment, $file);

            return view('pages.issues.comments.attachments.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified issue attachment.
     *
     * @param AttachmentRequest $request
     * @param int|string        $commentId
     * @param int|string        $issueId
     * @param string            $fileUuid
     *
     * @return bool
     */
    public function update(AttachmentRequest $request, $issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssueCommentPolicy::edit(auth()->user(), $issue, $comment)) {
            $file = $comment->findFile($fileUuid);

            return $this->dispatch(new Update($request, $file));
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified issue attachment.
     *
     * @param int|string $issueId
     * @param int|string $commentId
     * @param string     $fileUuid
     *
     * @return bool
     */
    public function destroy($issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssueCommentPolicy::destroy(auth()->user(), $issue, $comment)) {
            $file = $comment->findFile($fileUuid);

            return $file->delete();
        }

        $this->unauthorized();
    }

    /**
     * Returns a download response for the specified issue attachment.
     *
     * @param int|string $issueId
     * @param int|string $commentId
     * @param string     $fileUuid
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $comment = $issue->comments()->findOrFail($commentId);

        if (IssuePolicy::show(auth()->user(), $issue)) {
            $file = $comment->findFile($fileUuid);

            return response()->download($file->complete_path);
        }

        $this->unauthorized();
    }
}
