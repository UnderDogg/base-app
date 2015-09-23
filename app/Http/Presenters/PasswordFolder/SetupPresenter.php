<?php

namespace App\Http\Presenters\PasswordFolder;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\PasswordFolder;
use App\Http\Presenters\Presenter;

class SetupPresenter extends Presenter
{
    /**
     * Returns a new PasswordFolder form.
     *
     * @param PasswordFolder $folder
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form($folder)
    {
        return $this->form->of('issue', function (FormGrid $form) use ($folder)
        {
            $form->setup($this, route('issues.store'), $folder, [
                'method' => 'POST',
            ]);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'title')
                    ->label('Title')
                    ->attributes(['placeholder' => 'Title']);

                $fieldset->control('input:textarea', 'description')
                    ->label('Description')
                    ->attributes([
                        'placeholder' => 'Leave a comment',
                        'data-provide' => 'markdown',
                        'data-hidden-buttons' => '["cmdUrl","cmdImage"]',
                    ]);
            });
        });
    }
}
