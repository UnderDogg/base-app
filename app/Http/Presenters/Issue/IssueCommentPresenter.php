<?php

namespace App\Http\Presenters\Issue;

use App\Http\Presenters\CommentPresenter;
use App\Http\Presenters\Presenter;
use App\Models\Comment;
use App\Models\Issue;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

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
        return (new CommentPresenter($this->form, $this->table))->form($comment, function (FormGrid $form, Comment $comment) use ($issue) {
            // Check if the issue already has a resolution
            $hasResolution = $issue->findCommentResolution();

            if ($comment->exists) {
                $hash = sprintf('#comment-%s', $comment->getKey());
                $url = route('issues.comments.update', [$issue->getKey(), $comment->getKey(), $hash]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('issues.comments.store', [$issue->getKey(), '#comment']);
                $method = 'POST';

                $form->submit = 'Comment';
            }

            $form->attributes(compact('url', 'method'));

            // Setup the form fieldset
            $form->fieldset(function (Fieldset $fieldset) use ($comment, $hasResolution) {
                $isResolution = $comment->isResolution();

                // If the issue doesn't have a resolution, or the current comment
                // is the resolution, we'll add the mark resolution checkbox
                if (!$hasResolution || $isResolution) {
                    $fieldset->control('input:checkbox', 'Mark as Answer')
                        ->attributes([
                            'class' => 'switch-mark',
                            ($isResolution ? 'checked' : null),
                        ])
                        ->name('resolution')
                        ->value(1);
                }
            });
        });
    }
}
