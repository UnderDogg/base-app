<?php

namespace App\Http\Presenters\Computer;

use App\Http\Presenters\Presenter;
use App\Models\OperatingSystem;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class ComputerSystemPresenter extends Presenter
{
    /**
     * Returns a new table of all operating systems.
     *
     * @param OperatingSystem $system
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(OperatingSystem $system)
    {
        return $this->table->of('computers.operating-systems', function (TableGrid $table) use ($system) {
            $table->with($system)->paginate($this->perPage);

            $table->column('name');
            $table->column('version', function (Column $column) {
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes = function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                };
            });

            $table->column('service_pack', function (Column $column) {
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes = function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                };
            });

            $table->column('edit', function (Column $column) {
                $column->label = 'Edit';

                $column->value = function (OperatingSystem $system) {
                    return link_to_route('computer-systems.edit', 'Edit', [$system->id], [
                        'class' => 'btn btn-xs btn-warning',
                    ]);
                };
            });

            $table->column('delete', function (Column $column) {
                $column->label = 'Delete';

                $column->value = function (OperatingSystem $system) {
                    return link_to_route('computer-systems.destroy', 'Delete', [$system->id], [
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to delete this operating system?',
                        'class'        => 'btn btn-xs btn-danger',
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new form for the specified operating system.
     *
     * @param OperatingSystem $system
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(OperatingSystem $system)
    {
        return $this->form->of('computers.operating-systems', function (FormGrid $form) use ($system) {
            if ($system->exists) {
                $url = route('computer-systems.update', [$system->id]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('computer-systems.store');
                $method = 'POST';

                $form->submit = 'Create';
            }

            $form->attributes(compact('url', 'method'));

            $form->with($system);

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
            'url'        => route('computer-systems.index'),
            'menu'       => view('pages.computers.systems._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
