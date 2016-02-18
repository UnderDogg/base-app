<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachmentRequest;
use App\Processors\Issue\IssueAttachmentProcessor;

class IssueAttachmentController extends Controller
{
    /**
     * @var IssueAttachmentProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param IssueAttachmentProcessor $processor
     */
    public function __construct(IssueAttachmentProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the specified issue attachment.
     *
     * @param int|string $issueId
     * @param string     $fileUuid
     *
     * @return \Illuminate\View\View
     */
    public function show($issueId, $fileUuid)
    {
        return $this->processor->show($issueId, $fileUuid);
    }

    /**
     * Displays the form for editing the specified issue attachment.
     *
     * @param int|string $issueId
     * @param string     $fileUuid
     *
     * @return \Illuminate\View\View
     */
    public function edit($issueId, $fileUuid)
    {
        return $this->processor->edit($issueId, $fileUuid);
    }

    /**
     * Updates the specified issue attachment.
     *
     * @param AttachmentRequest $request
     * @param int|string        $issueId
     * @param string            $fileUuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttachmentRequest $request, $issueId, $fileUuid)
    {
        if ($this->processor->update($request, $issueId, $fileUuid)) {
            flash()->success('Success!', 'Successfully updated attachment.');

            return redirect()->route('issues.attachments.show', [$issueId, $fileUuid]);
        } else {
            flash()->error('Error!', 'There was an issue updating this attachment. Please try again.');

            return redirect()->route('issues.attachments.edit', [$issueId, $fileUuid]);
        }
    }

    /**
     * Deletes the specified issue attachment.
     *
     * @param int|string $issueId
     * @param string     $fileUuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($issueId, $fileUuid)
    {
        if ($this->processor->destroy($issueId, $fileUuid)) {
            flash()->success('Success!', 'Successfully deleted attachment.');

            return redirect()->route('issues.show', [$issueId]);
        } else {
            flash()->error('Error!', 'There was an issue deleting this attachment. Please try again.');

            return redirect()->route('issues.attachments.show', [$issueId, $fileUuid]);
        }
    }

    /**
     * Returns a download response for the specified issue attachment.
     *
     * @param int|string $issueId
     * @param string     $fileUuid
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($issueId, $fileUuid)
    {
        return $this->processor->download($issueId, $fileUuid);
    }
}
