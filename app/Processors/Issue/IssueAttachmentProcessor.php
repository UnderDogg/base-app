<?php

namespace App\Processors\Issue;

use App\Http\Presenters\Issue\IssueAttachmentPresenter;
use App\Http\Requests\AttachmentRequest;
use App\Jobs\Attachment\Update;
use App\Models\Issue;
use App\Processors\Processor;
use Orchestra\Support\Facades\ACL;

class IssueAttachmentProcessor extends Processor
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var IssueAttachmentPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Issue                    $issue
     * @param IssueAttachmentPresenter $presenter
     */
    public function __construct(Issue $issue, IssueAttachmentPresenter $presenter)
    {
        $this->issue = $issue;
        $this->presenter = $presenter;
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
        $issue = $this->issue->findOrFail($issueId);

        $file = $issue->findFile($fileUuid);

        return view('pages.issues.attachments.show', compact('issue', 'file'));
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
        $issue = $this->issue->findOrFail($issueId);

        $file = $issue->findFile($fileUuid);

        $form = $this->presenter->form($issue, $file);

        return view('pages.issues.attachments.edit', compact('form'));
    }

    /**
     * Updates the specified issue attachment.
     *
     * @param AttachmentRequest $request
     * @param int|string        $issueId
     * @param string            $fileUuid
     *
     * @return bool
     */
    public function update(AttachmentRequest $request, $issueId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $file = $issue->findFile($fileUuid);

        return $this->dispatch(new Update($request, $file));
    }

    /**
     * Deletes the specified issue attachment.
     *
     * @param int|string $issueId
     * @param string     $fileUuid
     *
     * @return bool
     */
    public function destroy($issueId, $fileUuid)
    {
        $issue = $this->issue->findOrFail($issueId);

        $file = $issue->findFile($fileUuid);

        return $file->delete();
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
        $issue = $this->issue->findOrFail($issueId);

        $file = $issue->findFile($fileUuid);

        return response()->download($file->complete_path);
    }
}
