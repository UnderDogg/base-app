<?php

namespace App\Http\Presenters\Computer;

use App\Http\Presenters\Presenter;
use App\Models\ComputerType;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

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

            $table->column('created_at_human', function (Column $column) {
                $column->label = 'Created';

                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes = function () {
                    return ['class' => 'hidden-xs'];
                };
            });

            $table->column('edit', function (Column $column) {
                $column->label = 'Edit';

                $column->value = function (ComputerType $type) {
                    return link_to_route('computer-types.edit', 'Edit', [$type->id], [
                        'class' => 'btn btn-xs btn-warning',
                    ]);
                };
            });

            $table->column('delete', function (Column $column) {
                $column->label = 'Delete';

                $column->value = function (ComputerType $type) {
                    return link_to_route('computer-types.destroy', 'Delete', [$type->id], [
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to delete this computer type?',
                        'class'        => 'btn btn-xs btn-danger',
                    ]);
                };
            });
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
                $url = route('computer-types.update', [$type->id]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('computer-types.store');
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
            'title'      => '<i class="fa fa-sitemap"></i> Computer Types',
            'url'        => route('computer-types.index'),
            'menu'       => view('pages.computers.types._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
