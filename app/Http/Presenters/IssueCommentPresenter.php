<?php

namespace App\Http\Presenters;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\Comment;
use App\Models\Issue;

class IssueCommentPresenter extends Presenter
{
    /**
     * Returns a form of the issue comment.
     *
     * @param Issue   $issue
     * @param Comment $comment
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Issue $issue, Comment $comment)
    {
        return $this->form->of('issue.comment', function (FormGrid $form) use ($issue, $comment)
        {
            $attributes = [
                'method' => 'PATCH',
            ];

            $form->setup($this, route('issues.comments.update', [$issue->getKey(), $comment->getKey()]), $comment, $attributes);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:textarea', 'content')
                    ->label('Comment')
                    ->attributes([
                        'placeholder' => 'Leave a comment',
                        'data-provide' => 'markdown',
                    ]);
            });

            $form->submit = 'Save';
        });
    }
}
