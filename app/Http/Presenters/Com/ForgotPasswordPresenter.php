<?php

namespace App\Http\Presenters\Com;

use App\Models\User;
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
                'url' => route('auth.forgot-password.find'),
            ]);

            $form->submit = 'Submit';

            $form->fieldset(function (Fieldset $fieldset)
            {
                $fieldset->control('input:text', 'username')
                    ->label('Username')
                    ->attributes(['placeholder' => 'Enter your Username']);
            });
        });
    }

    /**
     * Returns a new form for answering the specified users security questions.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formQuestions(User $user)
    {
        $questions = $user->questions;

        return $this->form->of('forgot-password', function (FormGrid $form) use ($user, $questions)
        {
            $form->attributes([
                'url' => route('auth.forgot-password.reset', [$user->forgot_token]),
            ]);

            $form->submit = 'Submit';

            $form->fieldset(function (Fieldset $fieldset) use ($questions)
            {
                foreach ($questions as $question) {
                    $key = $question->getKey();

                    $fieldset->control('input:text', "questions[$key]")
                        ->label($question->content)
                        ->attributes(['placeholder' => 'Enter your answer']);
                }
            });
        });
    }
}
