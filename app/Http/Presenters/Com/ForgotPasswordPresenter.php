<?php

namespace App\Http\Presenters\Com;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Http\Presenters\Presenter;

class ForgotPasswordPresenter extends Presenter
{
    /**
     * Returns a new form for resetting a users password.
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form()
    {
        return $this->form->of('forgot-password', function (FormGrid $form)
        {
            $form->attributes([
                'url' => route(''),
                'method' => 'PATCH',
            ]);

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset)
            {
                $fieldset->control('input:text', 'username')
                    ->label('Username')
                    ->attributes(['placeholder' => 'Enter your Username']);
            });
        });
    }
}
