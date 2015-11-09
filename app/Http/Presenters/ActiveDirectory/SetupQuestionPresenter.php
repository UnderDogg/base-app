<?php

namespace App\Http\Presenters\ActiveDirectory;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid;
use App\Models\Question;
use App\Models\User;
use App\Http\Presenters\Presenter;

class SetupQuestionPresenter extends Presenter
{
    /**
     * Returns a new form for setting up a users security questions.
     *
     * @param User     $user
     * @param Question $question
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user, Question $question)
    {
        $questions = $question->whereHas('users', function ($query) use ($user)
        {
            $query->where('user_id', '=', $user->getKey());
        }, '<', 1)->get()->lists('id', 'content');

        return $this->form->of('active-directory.questions.setup', function(Grid $form) use ($questions)
        {
            $form->fieldset(function (Fieldset $fieldset) use ($questions)
            {
                $fieldset->control('input:select', 'question')
                    ->label('Question')
                    ->options($questions);
            });
        });
    }
}
