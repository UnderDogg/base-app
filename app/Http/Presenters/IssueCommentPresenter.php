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
            // Check if the issue already has a resolution
            $hasResolution = $issue->findCommentResolution();

            if ($comment->exists) {
                $form->setup($this, route('issues.comments.update', [$issue->getKey(), $comment->getKey()]), $comment, ['method' => 'PATCH']);
            } else {
                $form->setup($this, route('issues.comments.store', [$issue->getKey()]), $comment);
            }

            // Setup the form fieldset
            $form->fieldset(function (Fieldset $fieldset) use ($comment, $hasResolution)
            {
                $fieldset->control('input:textarea', 'content')
                    ->label('Comment')
                    ->attributes([
                        'placeholder' => 'Leave a comment',
                        'data-provide' => 'markdown',
                    ]);

                // Check if the current comment is the resolution
                if ($comment->pivot) {
                    $isResolution = $comment->pivot->resolution;
                } else {
                    $isResolution = false;
                }

                // If the issue doesn't have a resolution, or the current comment
                // is the resolution, we'll add the mark resolution checkbox
                if (!$hasResolution || $isResolution) {
                    $fieldset->control('input:checkbox', 'Mark as Resolution', function ($control) use ($isResolution)
                    {
                        $control->field = function () use ($isResolution)
                        {
                            $checked = ($isResolution ? 'checked' : null);

                            return "<input name='resolution' class='switch-mark' $checked type='checkbox' value='1'>";
                        };
                    });
                }
            });

            $form->submit = 'Save';
        });
    }
}
