<?php

namespace App\Http\Presenters\Profile;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\User;
use App\Http\Presenters\Presenter;

class ProfilePresenter extends Presenter
{
    /**
     * Returns a new form for editing the current users profile.
     *
     * @param User $user
     * @param bool $viewing
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user, $viewing = false)
    {
        return $this->form->of('profile', function (FormGrid $form) use ($user, $viewing) {
            if ($viewing) {
                $form->setup($this, null, $user);

                $form->submit = 'Save';
            } else {
                $form->setup($this, '', $user);
            }

            $form->fieldset(function (Fieldset $fieldset) use ($viewing) {
                $fieldset->control('input:text', 'fullname')
                    ->label('Full Name')
                    ->attributes([
                        'placeholder' => 'Your Full Name',
                        ($viewing ? 'disabled' : null),
                    ]);

                $fieldset->control('input:text', 'email')
                    ->label('Email')
                    ->attributes([
                        'placeholder' => 'Your Email Address',
                        ($viewing ? 'disabled' : null),
                    ]);
            });
        });
    }
}
