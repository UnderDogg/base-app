<?php

namespace App\Http\Presenters;

use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class LabelPresenter extends Presenter
{
    /**
     * Returns a table of all labels.
     *
     * @param Label $label
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Label $label)
    {
        return $this->table->of('labels', function (TableGrid $table) use ($label) {
            $table->with($label)->paginate($this->perPage);

            $table->sortable([
                'name',
            ]);

            $table->column('name', function (Column $column) {
                $column->label = 'Label';

                $column->value = function (Label $label) {
                    return $label->display_large;
                };
            });

            $table->column('issues', function (Column $column) {
                $column->label = 'Open Issues';

                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->value = function (Label $label) {
                    return $label->issues()->open()->count();
                };

                $column->attributes = function () {
                    return ['class' => 'hidden-xs'];
                };
            });

            // Check if the current user has access to edit
            // labels before rendering the label as a link.
            if (Gate::allows('labels.edit')) {
                $table->column('edit', function (Column $column) {
                    $column->value = function (Label $label) {
                        return link_to_route('labels.edit', 'Edit', [$label->id], [
                            'class'  => 'btn btn-xs btn-warning',
                        ]);
                    };
                });
            }

            // Check if the current user has access to delete
            // labels before rendering the delete column.
            if (Gate::allows('labels.destroy')) {
                $table->column('delete', function (Column $column) {
                    $column->value = function (Label $label) {
                        return link_to_route('labels.destroy', 'Delete', [$label->id], [
                            'data-post'    => 'DELETE',
                            'data-title'   => 'Delete Label?',
                            'data-message' => 'Are you sure you want to delete this label?',
                            'class'        => 'btn btn-xs btn-danger',
                        ]);
                    };
                });
            }
        });
    }

    /**
     * Returns a form for labels.
     *
     * @param Label $label
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Label $label)
    {
        return $this->form->of('label', function (FormGrid $form) use ($label) {
            if ($label->exists) {
                $method = 'PATCH';
                $url = route('labels.update', [$label->id]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('labels.store');

                $form->submit = 'Create';
            }

            $form->with($label);
            $form->attributes(compact('method', 'url'));

            $options = $label::getColorsFormatted();

            $form->fieldset(function (Fieldset $fieldset) use ($options) {
                $fieldset->control('input:text', 'name')
                    ->label('Name')
                    ->attributes(['placeholder' => 'Name']);

                $fieldset->control('select', 'color')
                    ->label('Color')
                    ->options($options)
                    ->value(function (Label $label) {
                        return $label->color;
                    })
                    ->attributes([
                        'class'       => 'select-label-color form-control',
                        'placeholder' => 'Select a color',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the label index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'labels',
            'title'      => '<i class="fa fa-tags"></i> Labels',
            'url'        => route('labels.index'),
            'menu'       => view('pages.labels._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
