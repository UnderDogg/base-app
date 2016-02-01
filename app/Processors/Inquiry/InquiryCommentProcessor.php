<?php

namespace App\Processors\Inquiry;

use App\Http\Presenters\Inquiry\InquiryCommentPresenter;
use App\Http\Requests\Inquiry\InquiryCommentRequest;
use App\Models\Inquiry;
use App\Processors\Processor;

class InquiryCommentProcessor extends Processor
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

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
     * Creates an inquiry comment.
     *
     * @param InquiryCommentRequest $request
     * @param int|string            $inquiryId
     *
     * @return \App\Models\Comment|bool
     */
    public function store(InquiryCommentRequest $request, $inquiryId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $this->authorize($inquiry->comments()->getRelated());

        $attributes = [
            'content' => $request->input('content'),
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        return $inquiry->comments()->create($attributes);
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

        $this->authorize($comment);

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
     * @return bool
     */
    public function update(InquiryCommentRequest $request, $inquiryId, $commentId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $comment = $inquiry->comments()->findOrFail($commentId);

        $comment->content = $request->input('content', $comment->content);

        return $comment->save();
    }

    /**
     * Deletes the specified inquiry comment.
     *
     * @param int|string $inquiryId
     * @param int|string $commentId
     *
     * @return bool
     */
    public function destroy($inquiryId, $commentId)
    {
        $inquiry = $this->inquiry->findOrFail($inquiryId);

        $comment = $inquiry->comments()->findOrFail($commentId);

        $this->authorize($comment);

        $inquiry->comments()->detach($comment);

        return $comment->delete();
    }
}
