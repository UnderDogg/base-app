<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Inquiry\InquiryCommentPresenter;
use App\Http\Requests\Inquiry\InquiryCommentRequest;
use App\Models\Inquiry;

class InquiryCommentController extends Controller
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var InquiryCommentPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Inquiry                 $inquiry
     * @param InquiryCommentPresenter $presenter
     */
    public function __construct(Inquiry $inquiry, InquiryCommentPresenter $presenter)
    {
        $this->inquiry = $inquiry;
        $this->presenter = $presenter;
    }

    /**
     * Creates a new inquiry comment.
     *
     * @param InquiryCommentRequest $request
     * @param int|string            $inquiryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InquiryCommentRequest $request, $inquiryId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $this->authorize('inquiries.show', [$inquiry]);

        $attributes = [
            'content' => $request->input('content'),
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        if ($inquiry->comments()->create($attributes)) {
            flash()->success('Success!', 'Successfully created comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        }

        flash()->error('Error!', 'There was an issue creating a comment. Please try again.');

        return redirect()->route('inquiries.show', [$inquiryId]);
    }

    /**
     * Displays the form for editing the specified inquiry comment.
     *
     * @param int|string $inquiryId
     * @param int|string $commentId
     *
     * @return \Illuminate\View\View
     */
    public function edit($inquiryId, $commentId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $comment = $inquiry->comments()->findOrFail($commentId);

        $this->authorize('comments.edit', [$comment]);

        $form = $this->presenter->form($inquiry, $comment);

        return view('pages.inquiries.comments.edit', compact('form'));
    }

    /**
     * Updates the specified inquiry comment.
     *
     * @param InquiryCommentRequest $request
     * @param int|string            $inquiryId
     * @param int|string            $commentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InquiryCommentRequest $request, $inquiryId, $commentId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $comment = $inquiry->comments()->findOrFail($commentId);

        $this->authorize('comments.edit', [$comment]);

        $comment->content = $request->input('content', $comment->content);

        if ($comment->save()) {
            flash()->success('Success!', 'Successfully updated comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        }

        flash()->error('Error!', 'There was an issue updating this comment. Please try again.');

        return redirect()->route('inquiries.comments.edit', [$inquiryId, $commentId]);
    }

    /**
     * Deletes the specified comment.
     *
     * @param int|string $inquiryId
     * @param int|string $commentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($inquiryId, $commentId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $comment = $inquiry->comments()->findOrFail($commentId);

        $this->authorize('comments.destroy', [$comment]);

        $inquiry->comments()->detach($comment);

        if ($comment->delete()) {
            flash()->success('Success!', 'Successfully deleted comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        }

        flash()->error('Error!', 'There was an issue deleting this comment. Please try again.');

        return redirect()->route('inquiries.show', [$inquiryId]);
    }
}
