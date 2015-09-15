<?php

namespace App\Http\Presenters;

use App\Models\Label;
use Orchestra\Support\Facades\HTML;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
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
            $table->with($label, true);

            $table->sortable([
                'name',
            ]);

            $table->column('name', function ($column) {
                $column->label = 'Name';

                $column->value = function (Label $label) {
                    return link_to_route('labels.show', $label->name, [$label->getKey()]);
                };
            });
        });
    }

    public function form()
    {

    }
}
