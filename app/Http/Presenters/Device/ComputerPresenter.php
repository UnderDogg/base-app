<?php

namespace App\Http\Presenters\Device;

use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Models\Computer;
use App\Http\Presenters\Presenter;

class ComputerPresenter extends Presenter
{
    /**
     * Returns a new table of all computers.
     *
     * @param Computer $computer
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Computer $computer)
    {
        return $this->table->of('computers', function (TableGrid $table) use ($computer)
        {
            $table->with($computer)->paginate($this->perPage);

            $table->attributes('class', 'table table-hover');

            $table->searchable([
                'name',
                'os',
                'description',
            ]);

            $table->column('name', function ($column)
            {
                $column->label = 'Name';
                $column->value = function (Computer $computer)
                {
                    return link_to_route('devices.computers.show', $computer->name, [$computer->getKey()]);
                };
            });

            $table->column('description', function ($column)
            {
                $column->label = 'Description';
                $column->value = function (Computer $computer)
                {
                    return $computer->description;
                };
            });

            $table->column('os', function ($column)
            {
                $column->label = 'Operating System';
                $column->value = function (Computer $computer)
                {
                    return $computer->getCompleteOs();
                };
            });
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
