<?php

namespace App\Http\Presenters\Issue;

use App\Http\Presenters\Presenter;
use App\Models\Issue;
use App\Models\Upload;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class IssueAttachmentPresenter extends Presenter
{
    /**
     * Returns a new form for the specified issue attachment.
     *
     * @param Issue  $issue
     * @param Upload $file
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Issue $issue, Upload $file)
    {
        return $this->form->of('issues.attachments', function (FormGrid $form) use ($issue, $file) {
            $form->with($file);

            $method = 'PATCH';
            $url = route('issues.attachments.update', [$issue->id, $file->uuid]);

            $form->attributes(compact('method', 'url'));

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'name');
            });
        });
    }
}
