<?php

namespace App\Http\Presenters\Resource;

use App\Http\Presenters\Presenter;
use App\Models\Computer;
use App\Models\Patch;
use Carbon\Carbon;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class PatchComputerPresenter extends Presenter
{
    /**
     * Returns a new table of all computers
     * that contain the specified patch.
     *
     * @param Patch $patch
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Patch $patch)
    {
        $computers = $patch->computers();

        return $this->table->of('patches.computers', function (TableGrid $table) use ($patch, $computers) {
            $table->with($computers);

            $table->column('name', function (Column $column) {
                $column->value = function (Computer $computer) {
                    return link_to_route('computers.show', $computer->name, [$computer->id]);
                };
            });

            $table->column('patched', function (Column $column) {
                $column->value = function (Computer $computer) {
                    return (new Carbon($computer->patched_at))->diffForHumans();
                };
            });

            $table->column('remove', function (Column $column) use ($patch) {
                $column->value = function (Computer $computer) use ($patch) {
                    $params = [$patch->id, $computer->id];

                    return link_to_route('resources.patches.computers.destroy', 'Remove', $params, [
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you Sure?',
                        'data-message' => 'Are you sure you want to remove this patch from this computer?',
                        'class'        => 'btn btn-xs btn-danger',
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new form of the specified patch computers.
     *
     * @param Patch $patch
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Patch $patch)
    {
        return $this->form->of('patches.computers', function (FormGrid $form) use ($patch) {
            $form->attributes([
                'method' => 'POST',
                'url'    => route('resources.patches.computers.store', [$patch->id]),
            ]);

            $form->with($patch);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'patched')
                    ->label('Patched On')
                    ->attributes([
                        'class'       => 'date-picker',
                        'placeholder' => 'Click to select a date / time when the patch was applied.',
                    ]);

                $fieldset->control('input:select', 'computers[]')
                    ->label('Computers')
                    ->attributes([
                        'class'            => 'select-multiple',
                        'multiple'         => true,
                        'data-placeholder' => 'Select Computers',
                    ])->options(function (Patch $patch) {
                        $computers = $patch->computers()->get()->pluck('id');

                        return Computer::whereNotIn('id', $computers)->pluck('name', 'id');
                    });
            });
        });
    }
}
