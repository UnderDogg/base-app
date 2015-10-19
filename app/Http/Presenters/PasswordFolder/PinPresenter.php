<?php

namespace App\Http\Presenters\PasswordFolder;

use Orchestra\Html\Form\Grid as FormGrid;
use App\Http\Presenters\Presenter;

class PinPresenter extends Presenter
{
    public function form()
    {
        return $this->form->of('passwords.change-pin', function(FormGrid $form)
        {

        });
    }
}
