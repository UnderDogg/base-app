<?php

namespace App\Http\Presenters\Device;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Http\Presenters\Presenter;
use App\Models\ComputerType;

class ComputerTypePresenter extends Presenter
{
    /**
     * Returns a new table of all computer types.
     *
     * @param ComputerType $type
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(ComputerType $type)
    {
        return $this->table->of('computers.types', function (TableGrid $table) use ($type) {
            $table->with($type)->paginate($this->perPage);

            $table->column('name');
        });
    }

    /**
     * Returns a new form for the specified computer type.
     *
     * @param ComputerType $type
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(ComputerType $type)
    {
        return $this->form->of('computers.types', function (FormGrid $form) use ($type) {
            if ($type->exists) {
                $url = route('devices.computer-types.update', [$type->getKey()]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('devices.computer-types.store');
                $method = 'POST';

                $form->submit = 'Create';
            }

            $form->attributes(compact('url', 'method'));

            $form->with($type);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:text', 'name')
                    ->attributes([
                        'placeholder' => 'Enter the computer types name.',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the computer type index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'computer-types',
            'title'      => 'Computer Types',
            'url'        => route('devices.computer-types.index'),
            'menu'       => view('pages.devices.computers.types._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
