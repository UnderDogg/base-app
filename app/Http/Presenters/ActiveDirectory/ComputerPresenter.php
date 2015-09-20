<?php

namespace App\Http\Presenters\ActiveDirectory;

use Orchestra\Support\Facades\HTML;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Adldap\Models\Computer as AdComputer;
use App\Http\Presenters\Presenter;

class ComputerPresenter extends Presenter
{
    /**
     * Returns a new table of all computers.
     *
     * @param array $computers
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(array $computers = [])
    {
        return $this->table->of('computers', function(TableGrid $table) use ($computers) {
            $table->attributes('class', 'table table-hover');

            $table->rows($computers);

            $table->column('name', function ($column) {
                $column->label = 'Name';
                $column->value = function (AdComputer $computer) {
                    return $computer->getName();
                };
            });

            $table->column('description', function ($column) {
                $column->label = 'Description';
                $column->value = function (AdComputer $computer) {
                    return $computer->getDescription();
                };
            });

            $table->column('operating_system', function($column) {
                $column->label = 'Operating System';
                $column->value = function (AdComputer $computer) {
                    return $computer->getOperatingSystem();
                };
            });
        });
    }
}
