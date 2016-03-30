<?php

namespace App\Http\Presenters\Resource;

use App\Http\Presenters\Presenter;
use App\Models\Computer;
use App\Models\Patch;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class PatchPresenter extends Presenter
{
    /**
     * Returns a new table of all patches.
     *
     * @param Patch $patch
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Patch $patch)
    {
        return $this->table->of('patches', function (TableGrid $table) use ($patch) {
            $table->with($patch)->paginate($this->perPage);

            $table->column('title');

            $table->column('created_at_human')
                ->label('Created');
        });
    }

    /**
     * Returns a new form for the specified patch.
     *
     * @param Patch $patch
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Patch $patch)
    {
        return $this->form->of('patches', function (FormGrid $form) use ($patch) {
            if ($patch->exists) {
                $method = 'PATCH';
                $url = route('resource.patches.update', [$patch->getKey()]);
            } else {
                $method = 'POST';
                $url = route('resources.patches.store');
            }

            $form->attributes(compact('method', 'url'));

            $form->with($patch);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:select', 'computers[]')
                    ->label('Applies To')
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

                $fieldset->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter a Summary of the Patch.',
                    ]);

                $fieldset->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder'  => 'What was done to the machine?',
                        'style'        => 'min-height:350px;',
                        'data-provide' => 'markdown',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the patches index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'resources-patches',
            'title'      => 'Patches',
            'url'        => route('resources.patches.index'),
            'menu'       => view('pages.resources.patches._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
