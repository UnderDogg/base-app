<?php

namespace App\Http\Presenters\Issue;

use App\Http\Presenters\Presenter;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Upload;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class IssueCommentAttachmentPresenter extends Presenter
{
    /**
     * Returns a new form for the specified issue comment attachment.
     *
     * @param Issue   $issue
     * @param Comment $comment
     * @param Upload  $file
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Issue $issue, Comment $comment, Upload $file)
    {
        return $this->form->of('issues.comments.attachments', function (FormGrid $form) use ($issue, $comment, $file) {
            $form->with($file);

            $method = 'PATCH';
            $url = route('issues.comments.attachments.update', [$issue->getKey(), $comment->getKey(), $file->uuid]);

            $form->attributes(compact('method', 'url'));

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'name');
            });
        });
    }
}
