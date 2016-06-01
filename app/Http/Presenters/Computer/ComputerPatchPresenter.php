<?php

namespace App\Http\Presenters\Computer;

use App\Http\Presenters\Presenter;
use App\Http\Presenters\Resource\PatchPresenter;
use App\Models\Computer;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class ComputerPatchPresenter extends Presenter
{
    /**
     * Returns a new table of all of the specified computers patches.
     *
     * @param Computer $computer
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Computer $computer)
    {
        return (new PatchPresenter($this->form, $this->table))->table($computer->patches());
    }

    /**
     * @param Computer $computer
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Computer $computer)
    {
        return $this->form->of('computers.patches', function (FormGrid $form) use ($computer) {
        });
    }

    /**
     * Returns a new navbar when displaying the specified computer patch.
     *
     * @param Computer $computer
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Computer $computer)
    {
        return (new ComputerPresenter($this->form, $this->table))->navbarShow($computer);
    }
}
