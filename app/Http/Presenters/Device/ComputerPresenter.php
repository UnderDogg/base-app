<?php

namespace App\Http\Presenters\Device;

use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Models\Computer;
use App\Http\Presenters\Presenter;

class ComputerPresenter extends Presenter
{
    public function table(Computer $computer)
    {
        return $this->table->of('computers', function (TableGrid $table) use ($computer)
        {
            $table->with($computer)->paginate($this->perPage);

            $table->searchable([
                'name',
                'description',
                'model',
            ]);
        });
    }

    public function form(Computer $computer)
    {
        //
    }

    /**
     * Returns a new navbar for the computer index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'    => 'computers',
            'title' => 'Computers',
            'url'   => route('devices.computers.index'),
            'menu'  => view('pages.devices.computers._nav'),
            'attributes' => [
                'class' => 'navbar-default'
            ],
        ]);
    }
}
