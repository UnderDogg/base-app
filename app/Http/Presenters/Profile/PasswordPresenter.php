<?php

namespace App\Http\Presenters\Profile;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Http\Presenters\Presenter;

class PasswordPresenter extends Presenter
{
    /**
     * Returns a new change password form for the current user.
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form()
    {
        return $this->form->of('profile.password', function (FormGrid $form)
        {
            $form->submit = 'Update';

            $form->attributes([
                'url' => route('profile.password.change'),
            ]);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:password', 'current_password')
                    ->label('Current Password')
                    ->attributes([
                        'placeholder' => 'Your Current Password',
                    ]);

                $fieldset->control('input:password', 'password')
                    ->label('New Password')
                    ->attributes([
                        'placeholder' => 'Your New Password',
                    ]);

                $fieldset->control('input:password', 'password_confirmation')
                    ->label('Confirm New Password')
                    ->attributes([
                        'placeholder' => 'Confirm Your New Password',
                    ]);
            });
        });
    }
}
