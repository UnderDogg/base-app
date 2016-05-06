<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Issue\IssueCommentPresenter;
use App\Http\Requests\Issue\IssueCommentCreateRequest;
use App\Http\Requests\Issue\IssueCommentUpdateRequest;
use App\Models\Issue;

class IssueCommentController extends Controller
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
     * Creates a comment and attaches it to the specified issue.
     *
     * @param IssueCommentCreateRequest $request
     * @param int|string                $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueCommentCreateRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize('issues.show', [$issue]);

        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully added comment.');

            return redirect()->back();
        }

        flash()->error('Error!', 'There was a problem adding a comment. Please try again.');

        return redirect()->back();
    }

    /**
     * Displays the form to edit the specified issue comment.
     *
     * @param int|string $id
     * @param int|string $commentId
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $commentId)
    {
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->with(['files'])->findOrFail($commentId);

        $this->authorize('comments.edit', [$comment]);

        $form = $this->presenter->form($issue, $comment);

        return view('pages.issues.comments.edit', compact('form'));
    }

    /**
     * Updates the specified issue comment.
     *
     * @param IssueCommentUpdateRequest $request
     * @param int|string                $id
     * @param int|string                $commentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IssueCommentUpdateRequest $request, $id, $commentId)
    {
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        $this->authorize('comments.edit', [$comment]);

        if ($request->persist($issue, $comment)) {
            flash()->success('Success!', 'Successfully updated comment.');

            return redirect()->route('issues.show', [$id]);
        }

        flash()->error('Error!', 'There was a problem updating this comment. Please try again.');

        return redirect()->route('issues.show', [$id]);
    }

    /**
     * Deletes the specified issues comment.
     *
     * @param int|string $id
     * @param int|string $commentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $commentId)
    {
        $issue = $this->issue->findOrFail($id);

        $comment = $issue->comments()->findOrFail($commentId);

        $this->authorize('comments.destroy', [$comment]);

        $issue->comments()->detach($comment);

        if ($comment->delete()) {
            flash()->success('Success!', 'Successfully deleted comment.');

            return redirect()->back();
        }

        flash()->error('Error!', 'There was a problem deleting this comment. Please try again.');

        return redirect()->back();
    }
}
