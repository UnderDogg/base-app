<?php

namespace App\Http\Presenters\Resource;

use App\Http\Presenters\Presenter;
use App\Models\Guide;
use App\Models\GuideStep;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class GuidePresenter extends Presenter
{
    /**
     * Returns a new table of all guides.
     *
     * @param Guide|Builder $guide
     * @param bool|false    $favorites
     * @param null|Closure  $closure
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($guide, $favorites = false, Closure $closure = null)
    {
        $guide = $guide->latest();

        // Limit the view if the user isn't allowed
        // to view unpublished guides.
        if (Auth::user()->cannot('manage.guides')) {
            $guide->where(['published' => true]);
        }

        // Limit the view to favorites only if specified.
        if ($favorites) {
            $guide->whereHas('favorites', function ($query) {
                $query->where(['user_id' => auth()->user()->id]);
            });
        }

        return $this->table->of('resources.guides', function (TableGrid $table) use ($guide, $closure) {
            if (is_null($closure)) {
                $table->with($guide)->paginate($this->perPage);
            } else {
                $table = call_user_func($closure, $table, $guide);
            }

            $table
                ->column('title')
                ->value(function (Guide $guide) {
                    return link_to_route('resources.guides.show', $guide->title, [$guide->slug]);
                });

            $table
                ->column('published')
                ->value(function (Guide $guide) {
                    return $guide->published_label;
                })
                ->headers([
                    'class' => 'hidden-xs',
                ])
                ->attributes(function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                });

            // Only allow users with create guide permissions
            // to see the created date.
            if (Auth::user()->can('manage.guides')) {
                $table
                    ->column('created_at')
                    ->label('Created')
                    ->value(function (Guide $guide) {
                        return $guide->created_at_human;
                    });
            }
        });
    }

    /**
     * Displays the last 5 created guides.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableLast(Guide $guide)
    {
        return $this->table($guide, false, function (TableGrid $table, Builder $builder) {
            $guides = $builder->limit(5);

            $table->with($guides, false);

            return $table;
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
        return $this->form->of('resources.guides', function (FormGrid $form) use ($guide) {
            if ($guide->exists) {
                $form->attributes([
                    'method'    => 'patch',
                    'url'       => route('resources.guides.update', [$guide->slug]),
                ]);

                $form->submit = 'Save';
            } else {
                $form->attributes([
                    'method'    => 'post',
                    'url'       => route('resources.guides.store'),
                ]);

                $form->submit = 'Create';
            }

            $form->with($guide);

            $form->fieldset(function (Fieldset $fieldset) use ($guide) {
                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'class'           => 'slug',
                        'placeholder'     => 'Enter the guide title',
                        'data-slug-field' => '#slug',
                    ])->value(function (Guide $guide) {
                        return $guide->exists ? $guide->title : 'How To:';
                    });

                $fieldset
                    ->control('input:text', 'slug')
                    ->attributes([
                        'placeholder' => 'Enter the guide slug',
                    ])->value(function (Guide $guide) {
                        return $guide->exists ? $guide->slug : 'how-to';
                    });

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder'  => 'Enter the guide description',
                        'data-provide' => 'markdown',
                    ]);

                $fieldset
                    ->control('input:checkbox', 'publish')
                    ->attributes([
                        'class' => 'switch-mark',
                        ($guide->published ? 'checked' : null),
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

        return $presenter->form($guide, new GuideStep());
    }

    /**
     * Returns a new navbar for the guide index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'guides',
            'title'      => '<i class="fa fa-bookmark-o"></i> Guides',
            'url'        => route('resources.guides.index'),
            'menu'       => view('pages.resources.guides._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }

    /**
     * Returns a new navbar for the guide step show page.
     *
     * @param Guide $guide
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbarShow(Guide $guide)
    {
        return $this->fluent([
            'id'         => 'guide-steps-show',
            'title'      => 'Actions',
            'url'        => route('resources.guides.show', [$guide->slug]),
            'menu'       => view('pages.resources.guides._nav-show', compact('guide')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
