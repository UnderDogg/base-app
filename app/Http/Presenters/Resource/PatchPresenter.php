<?php

namespace App\Http\Presenters\Resource;

use App\Http\Presenters\Presenter;
use App\Models\Patch;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
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
        $patch = $patch->with(['computers']);

        return $this->table->of('patches', function (TableGrid $table) use ($patch) {
            $table->with($patch)->paginate($this->perPage);

            $table->searchable([
                'title',
                'description',
            ]);

            $table->column('title', function (Column $column) {
                $column->value = function (Patch $patch) {
                    $link = link_to_route('resources.patches.show', $patch->title, [$patch->id], [
                        'class' => 'table-lead-title',
                    ]);

                    $tagLine = sprintf('<p class="h5 table-lead-summary">%s</p>', $patch->tag_line);

                    return "$link $tagLine";
                };
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function tableComputers(Patch $patch)
    {
        return (new PatchComputerPresenter($this->form, $this->table))->table($patch);
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
                $url = route('resources.patches.update', [$patch->id]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('resources.patches.store');

                $form->submit = 'Create';
            }

            $files = true;

            $form->attributes(compact('method', 'url', 'files'));

            $form->with($patch);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter a Summary of the Patch.',
                    ]);

                $fieldset->control('input:file', 'files[]')
                    ->label('Attach Files')
                    ->attributes([
                        'multiple' => true,
                    ]);

                $fieldset->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder'  => 'What was done to the machine?',
                        'style'        => 'min-height:350px;',
                    ]);
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function formComputers(Patch $patch)
    {
        return (new PatchComputerPresenter($this->form, $this->table))->form($patch);
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
            'title'      => '<i class="fa fa-medkit"></i> Patches',
            'url'        => route('resources.patches.index'),
            'menu'       => view('pages.resources.patches._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
