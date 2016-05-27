<?php

namespace App\Models\Traits;

trait HasPresenter
{
    /**
     * @return \App\Models\Presenters\Presenter
     */
    abstract function present();
}
