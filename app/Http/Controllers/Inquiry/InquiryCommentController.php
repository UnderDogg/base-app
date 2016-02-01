<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Requests\Inquiry\InquiryCommentRequest;
use App\Processors\Inquiry\InquiryCommentProcessor;
use App\Http\Controllers\Controller;

class InquiryCommentController extends Controller
{
    /**
     * @var InquiryCommentProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param InquiryCommentProcessor $processor
     */
    public function __construct(InquiryCommentProcessor $processor)
    {
        $this->processor = $processor;
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
        if ($this->processor->store($request, $inquiryId)) {
            flash()->success('Success!', 'Successfully created comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        } else {
            flash()->error('Error!', 'There was an issue creating a comment. Please try again.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        }
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
        return $this->processor->edit($inquiryId, $commentId);
    }

    /**
     * Updates the specified inquiry comment.
     *
     * @param InquiryCommentRequest $request
     * @param int|string            $inquiryId
     * @param int|string             $commentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InquiryCommentRequest $request, $inquiryId, $commentId)
    {
        if ($this->processor->update($request, $inquiryId, $commentId)) {
            flash()->success('Success!', 'Successfully updated comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        } else {
            flash()->error('Error!', 'There was an issue updating this comment. Please try again.');

            return redirect()->route('inquiries.comments.edit', [$inquiryId, $commentId]);
        }
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
        if ($this->processor->destroy($inquiryId, $commentId)) {
            flash()->success('Success!', 'Successfully deleted comment.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        } else {
            flash()->error('Error!', 'There was an issue deleting this comment. Please try again.');

            return redirect()->route('inquiries.show', [$inquiryId]);
        }
    }
}
