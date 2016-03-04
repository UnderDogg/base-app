<?php

namespace App\Http\Controllers\Issue;

use App\Http\Requests\AttachmentRequest;
use App\Http\Controllers\Controller;
use App\Processors\Issue\IssueCommentAttachmentProcessor;

class IssueCommentAttachmentController extends Controller
{
    /**
     * @var IssueCommentAttachmentProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param IssueCommentAttachmentProcessor $processor
     */
    public function __construct(IssueCommentAttachmentProcessor $processor)
    {
        $this->processor = $processor;
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
        return $this->processor->show($issueId, $commentId, $fileUuid);
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
        return $this->processor->edit($issueId, $commentId, $fileUuid);
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
        if ($this->processor->update($request, $issueId, $commentId, $fileUuid)) {
            flash()->success('Success!', 'Successfully comment updated attachment.');

            return redirect()->route('issues.comments.attachments.show', [$issueId, $commentId, $fileUuid]);
        } else {
            flash()->error('Error!', 'There was an issue updating this comment attachment. Please try again.');

            return redirect()->route('issues.comments.attachments.edit', [$issueId, $commentId, $fileUuid]);
        }
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
        if ($this->processor->destroy($issueId, $commentId, $fileUuid)) {
            flash()->success('Success!', 'Successfully deleted attachment.');

            return redirect()->route('issues.show', [$issueId]);
        } else {
            flash()->error('Error!', 'There was an issue deleting this comment attachment. Please try again.');

            return redirect()->route('issues.comments.attachments.show', [$issueId, $commentId, $fileUuid]);
        }
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
        return $this->processor->download($issueId, $commentId, $fileUuid);
    }
}
