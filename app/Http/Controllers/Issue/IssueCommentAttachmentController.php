<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Issue\IssueCommentAttachmentPresenter;
use App\Http\Requests\AttachmentRequest;
use App\Models\Issue;

class IssueCommentAttachmentController extends Controller
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

        $this->authorize($issue);

        $comment = $issue->comments()->findOrFail($commentId);

        $file = $comment->findFile($fileUuid);

        return view('pages.issues.comments.attachments.show', compact('issue', 'comment', 'file'));
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

        $this->authorize($issue);

        $comment = $issue->comments()->findOrFail($commentId);

        $file = $comment->findFile($fileUuid);

        $form = $this->presenter->form($issue, $comment, $file);

        return view('pages.issues.comments.attachments.edit', compact('form'));
    }

    /**
     * Updates the specified issue attachment.
     *
     * @param AttachmentRequest $request
     * @param int|string        $issueId
     * @param int|string        $commentId
     * @param string            $fileUuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttachmentRequest $request, $issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $this->authorize($issue);

        $comment = $issue->comments()->findOrFail($commentId);

        $file = $comment->findFile($fileUuid);

        if ($request->persist($file)) {
            flash()->success('Success!', 'Successfully comment updated attachment.');

            return redirect()->route('issues.comments.attachments.show', [$issueId, $commentId, $fileUuid]);
        }

        flash()->error('Error!', 'There was an issue updating this comment attachment. Please try again.');

        return redirect()->route('issues.comments.attachments.edit', [$issueId, $commentId, $fileUuid]);
    }

    /**
     * Deletes the specified issue attachment.
     *
     * @param int|string $issueId
     * @param int|string $commentId
     * @param string     $fileUuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($issueId, $commentId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $this->authorize($issue);

        $comment = $issue->comments()->findOrFail($commentId);

        $file = $comment->findFile($fileUuid);

        if ($file->delete()) {
            flash()->success('Success!', 'Successfully deleted attachment.');

            return redirect()->route('issues.show', [$issueId]);
        }

        flash()->error('Error!', 'There was an issue deleting this comment attachment. Please try again.');

        return redirect()->route('issues.comments.attachments.show', [$issueId, $commentId, $fileUuid]);
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

        $this->authorize($issue);

        $comment = $issue->comments()->findOrFail($commentId);

        $file = $comment->findFile($fileUuid);

        if ($path = $file->complete_path) {
            return response()->download($path);
        }

        // The path doesn't exist, which means the file does
        // not exist. We'll delete the file to prevent
        // users from accessing it again.
        $file->delete();

        abort(404);
    }
}
