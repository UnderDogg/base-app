<?php

namespace App\Http\Presenters\Inquiry;

use App\Http\Presenters\CommentPresenter;
use App\Http\Presenters\Presenter;
use App\Models\Comment;
use App\Models\Inquiry;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class InquiryCommentPresenter extends Presenter
{
    /**
     * Returns a form of the issue comment.
     *
     * @param Inquiry $inquiry
     * @param Comment $comment
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Inquiry $inquiry, Comment $comment)
    {
        return (new CommentPresenter($this->form, $this->table))->form($comment, function (FormGrid $form, Comment $comment) use ($inquiry) {
            if ($comment->exists) {
                $url = route('inquiries.comments.update', [$inquiry->id, $comment->id, $comment->hash_id]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('inquiries.comments.store', [$inquiry->id, '#comment']);
                $method = 'POST';

                $form->submit = 'Comment';
            }

            $form->attributes(compact('url', 'method'));
        });
    }
}
