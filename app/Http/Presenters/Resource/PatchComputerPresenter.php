<?php

namespace App\Http\Presenters\Resource;

use  Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Html\Form\Grid as FormGrid;
use App\Http\Presenters\Presenter;
use App\Models\Computer;
use App\Models\Patch;

class PatchComputerPresenter extends Presenter
{
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
                'method' => 'PATCH',
                'url' => route('patches.computers.store', [$patch->getKey()]),
            ]);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:select', 'computers[]')
                    ->label('Computers')
                    ->attributes([
                        'class'            => 'select-users',
                        'multiple'         => true,
                        'data-placeholder' => 'Select Computers Applied To',
                    ])->value(function (Patch $patch) {
                        if ($patch->exists) {
                            return $patch->computers()->get()->pluck('id');
                        }
                    })->options(function () {
                        return Computer::all()->pluck('name', 'id');
                    });
            });
        });
    }
}
