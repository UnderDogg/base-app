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

            $form->layout('pages.passwords._form');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:password', 'pin')
                    ->label('Pin')
                    ->attributes(['placeholder' => 'Enter your Pin']);

                $fieldset->control('input:password', 'pin')
                    ->label('Confirm Pin')
                    ->attributes([
                        'placeholder' => 'Confirm your above Pin',
                    ]);
            });
        });
    }
}
