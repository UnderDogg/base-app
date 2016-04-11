<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Issue\IssueAttachmentPresenter;
use App\Http\Requests\AttachmentRequest;
use App\Models\Issue;
use App\Policies\IssuePolicy;

class IssueAttachmentController extends Controller
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

        if (IssuePolicy::show(auth()->user(), $issue)) {
            $file = $issue->findFile($fileUuid);

            return view('pages.issues.attachments.show', compact('issue', 'file'));
        }

        $this->unauthorized();
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

        if (IssuePolicy::edit(auth()->user(), $issue)) {
            $file = $issue->findFile($fileUuid);

            $form = $this->presenter->form($issue, $file);

            return view('pages.issues.attachments.edit', compact('form'));
        }

        $this->unauthorized();
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
        $issue = $this->issue->findOrFail($issueId);

        if (IssuePolicy::edit(auth()->user(), $issue)) {
            $file = $issue->findFile($fileUuid);

            if ($request->persist($file)) {
                flash()->success('Success!', 'Successfully updated attachment.');

                return redirect()->route('issues.attachments.show', [$issueId, $fileUuid]);
            }

            flash()->error('Error!', 'There was an issue updating this attachment. Please try again.');

            return redirect()->route('issues.attachments.edit', [$issueId, $fileUuid]);
        }

        $this->unauthorized();
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
        $issue = $this->issue->findOrFail($issueId);

        if (IssuePolicy::destroy(auth()->user(), $issue)) {
            $file = $issue->findFile($fileUuid);

            if ($file->delete()) {
                flash()->success('Success!', 'Successfully deleted attachment.');

                return redirect()->route('issues.show', [$issueId]);
            }

            flash()->error('Error!', 'There was an issue deleting this attachment. Please try again.');

            return redirect()->route('issues.attachments.show', [$issueId, $fileUuid]);
        }

        $this->unauthorized();
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

        if (IssuePolicy::show(auth()->user(), $issue)) {
            $file = $issue->findFile($fileUuid);

            if ($path = $file->complete_path) {
                return response()->download($path);
            }

            $file->delete();

            abort(404);
        }

        $this->unauthorized();
    }
}
