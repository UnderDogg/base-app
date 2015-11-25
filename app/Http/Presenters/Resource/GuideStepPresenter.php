<?php

namespace App\Http\Presenters\Resource;

use App\Models\Guide;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\GuideStep;
use App\Http\Presenters\Presenter;

class GuideStepPresenter extends Presenter
{
    /**
     * Returns a new form of the guide step.
     *
     * @param Guide     $guide
     * @param GuideStep $step
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Guide $guide, GuideStep $step)
    {
        return $this->form->of('resources.guides.steps', function (FormGrid $form) use ($guide, $step)
        {
            $attributes = [
                'files' => true
            ];

            if ($step->exists) {
                $route = route('resources.guides.steps.update', [$guide->getSlug(), $step->getPosition()]);
                $attributes['method'] = 'PATCH';

                $form->submit = 'Update Step';
            } else {
                $route = route('resources.guides.steps.store', [$guide->getSlug()]);
                $attributes['method'] = 'POST';

                $form->submit = 'Add Step';
            }

            $form->setup($this, $route, $step, $attributes);

            $form->fieldset(function (Fieldset $fieldset)
            {
                $fieldset->control('input:file', 'image');

                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the step title',
                    ]);

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the step description',
                    ]);
            });
        });
    }

    /**
     * Returns a new table of the guide steps.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Guide $guide)
    {
        $steps = $guide->steps()->orderBy('position');

        return $this->table->of('resources.guides', function (TableGrid $table) use ($guide, $steps) {
            $table->with($steps)->paginate($this->perPage);

            $table->layout('pages.resources.guides.steps._table');

            $table->attributes(['class' => 'table table-hover']);

            $table->column('move')
                ->attributes(function (GuideStep $step) {
                    return [
                        'class' => 'sortable-handle',
                        'data-id' => $step->getKey(),
                    ];
                })
                ->value(function () {
                    return '<i class="fa fa-sort"></i>';
                });

            $table->column('Step', 'position')
                ->attributes(function ()
                {
                    return ['class' => 'position'];
                });

            $table
                ->column('title')
                ->value(function (GuideStep $step) use ($guide) {
                    return link_to_route('resources.guides.steps.edit', $step->title, [$guide->getSlug(), $step->getPosition()]);
                });

            $table
                ->column('description')
                ->value(function (GuideStep $step) {
                    return $step->description;
                });
        });
    }

    /**
     * Returns a new navbar for the guide step index.
     *
     * @param Guide $guide
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Guide $guide)
    {
        return $this->fluent([
            'id'    => 'guide-steps',
            'title' => 'Guide Steps',
            'url'   => route('resources.guides.steps.index', [$guide->getSlug()]),
            'menu'  => view('pages.resources.guides.steps._nav', compact('guide')),
            'attributes' => [
                'class' => 'navbar-default'
            ],
        ]);
    }
}
