<?php

namespace App\Http\Presenters\Device;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Http\Presenters\Presenter;
use App\Models\OperatingSystem;

class ComputerSystemPresenter extends Presenter
{
    /**
     * Returns a new table of all operating systems.
     *
     * @param OperatingSystem $os
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(OperatingSystem $os)
    {
        return $this->table->of('computers.operating-systems', function (TableGrid $table) use ($os) {
            $table->with($os)->paginate($this->perPage);

            $table->column('name');
            $table->column('version');
            $table->column('service_pack');

            $table->column('edit');
            $table->column('delete');
        });
    }

    /**
     * Returns a new form for the specified operating system.
     *
     * @param OperatingSystem $os
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(OperatingSystem $os)
    {
        return $this->form->of('computers.operating-systems', function (FormGrid $form) use ($os) {
            if ($os->exists) {
                $url = route('devices.computer-systems.update', [$os->getKey()]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('devices.computer-systems.store');
                $method = 'POST';

                $form->submit = 'Create';
            }

            $form->attributes(compact('url', 'method'));

            $form->with($os);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:text', 'name')
                    ->attributes([
                        'placeholder' => 'Enter the operating systems name.',
                    ]);

                $fieldset
                    ->control('input:text', 'version')
                    ->attributes([
                        'placeholder' => 'Enter the operating systems version.',
                    ]);

                $fieldset
                    ->control('input:text', 'service_pack')
                    ->attributes([
                        'placeholder' => 'Enter the operating systems service pack.',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the operating system index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'computer-systems',
            'title'      => 'Operating Systems',
            'url'        => route('devices.computer-systems.index'),
            'menu'       => view('pages.devices.computers.systems._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
