<?php

namespace App\Http\Presenters\Resource;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Models\Guide;
use App\Http\Presenters\Presenter;

class GuidePresenter extends Presenter
{
    /**
     * Returns a new table of all guides.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Guide $guide)
    {
        $guide = $guide->query()->latest();

        return $this->table->of('resources.guides', function (TableGrid $table) use ($guide)
        {
            $table->with($guide)->paginate($this->perPage);

            $table->searchable([
                'title',
                'description',
            ]);

            $table->attributes(['class' => 'table table-hover']);

            $table
                ->column('title')
                ->value(function (Guide $guide)
                {
                    return link_to_route('resources.guides.show', $guide->title, [$guide->slug]);
                });

            $table
                ->column('summary')
                ->value(function (Guide $guide)
                {
                    return $guide->summary();
                });

            $table
                ->column('published')
                ->value(function (Guide $guide)
                {
                    return $guide->publishedLabel();
                });

            $table
                ->column('created_at', function (Column $column)
                {
                    $column->label = 'Created';
                })->value(function (Guide $guide)
                {
                    return $guide->createdAtHuman();
                });
        });
    }

    /**
     * Returns a new form of the specified guide.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Guide $guide)
    {
        return $this->form->of('resources.guides', function (FormGrid $form) use ($guide)
        {
            if ($guide->exists) {
                $route = route('resources.guides.update', [$guide->slug]);
                $method = 'PATCH';
            } else {
                $route = route('resources.guides.store');
                $method = 'POST';
            }

            $form->setup($this, $route, $guide, compact('method'));

            $form->fieldset(function (Fieldset $fieldset) use ($guide)
            {
                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'class' => 'slug',
                        'placeholder' => 'Enter the guide title',
                        'data-slug-field' => '#slug',
                    ])->value(function (Guide $guide) {
                        if ($guide->exists) return $guide->title;

                        return 'How To:';
                    });

                $fieldset
                    ->control('input:text', 'slug')
                    ->attributes([
                        'placeholder' => 'Enter the guide slug',
                    ])->value(function (Guide $guide)
                    {
                        if ($guide->exists) return $guide->slug;

                        return 'how-to';
                    });

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the guide description',
                        'data-provide' => 'markdown',
                    ]);

                $fieldset
                    ->control('input:checkbox', 'publish')
                    ->attributes([
                        'class' => 'switch-mark',
                        ($guide->published ? 'checked' : null)
                    ])
                    ->value(1);
            });
        });
    }

    /**
     * Returns a new form of the guide step.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formStep(Guide $guide)
    {
        $presenter = new GuideStepPresenter($this->form, $this->table);

        return $presenter->form($guide, $guide->steps()->getRelated());
    }

    /**
     * Returns a new navbar for the issue index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'    => 'guides',
            'title' => 'Guides',
            'url'   => route('resources.guides.index'),
            'menu'  => view('pages.resources.guides._nav'),
            'attributes' => [
                'class' => 'navbar-default'
            ],
        ]);
    }
}
