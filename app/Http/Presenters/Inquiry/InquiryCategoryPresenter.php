<?php

namespace App\Http\Presenters\Inquiry;

use App\Http\Presenters\Presenter;
use App\Models\Category;
use App\Models\Inquiry;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class InquiryCategoryPresenter extends Presenter
{
    /**
     * Returns a new table of inquiry categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Category $category
     * @param Inquiry                                        $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($category, Inquiry $inquiry)
    {
        if ($category->exists) {
            // If the category exists we're looking to display it's children.
            $category = $category
                ->children();
        } else {
            // Otherwise we're displaying root nodes.
            $category = $category
                ->roots()
                ->whereBelongsTo($inquiry->getTable());
        }

        return $this->table->of('inquiries.categories', function (TableGrid $table) use ($category) {
            $table->with($category)->paginate($this->perPage);

            $table->layout('pages.categories._table');

            $table->column('name', function (Column $column) {
                $column->value = function (Category $category) {
                    return link_to_route('inquiries.categories.index', $category->name, [$category->getKey()]);
                };
            });

            $table->column('sub-categories', function (Column $column) {
                $column->value = function (Category $category) {
                    return $category->children()->count();
                };
            });

            $table->column('delete', function (Column $column) {
                $column->value = function (Category $category) {
                    $route = 'inquiries.categories.destroy';

                    return link_to_route($route, 'Delete', [$category->getKey()], [
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Delete Category?',
                        'data-message' => 'Are you sure you want to delete this category? All child categories will be destroyed.',
                        'class'        => 'btn btn-xs btn-danger',
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new form of the specified category.
     *
     * @param Category      $category
     * @param Category|null $parent
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Category $category, Category $parent = null)
    {
        return $this->form->of('inquiries.categories', function (FormGrid $form) use ($category, $parent) {
            if ($category->exists) {
                // If the category exists we need to setup alternate form parameters.
                $url = route('inquiries.categories.update', [$category->getKey()]);
                $method = 'PATCH';
                $form->submit = 'Update';
            } else {
                $params = [];

                // If a parent is given, we're creating a sub-category underneath
                // it, otherwise we're creating a rood category.
                if ($parent instanceof Category) {
                    $params[] = $parent->getKey();
                }

                $url = route('inquiries.categories.store', $params);
                $method = 'POST';
                $form->submit = 'Create';
            }

            $form->attributes(compact('url', 'method'));

            $form->with($category);

            $form->fieldset(function (Fieldset $fieldset) use ($category, $parent) {
                $fieldset
                    ->control('select', 'parent', function ($field) use ($category, $parent) {
                        $field->value = function () use ($category, $parent) {
                            if ($parent && $parent->exists) {
                                return $parent->getKey();
                            }
                        };

                        if ($category->exists) {
                            $except = [$category->getKey()];
                            $first = 'Select a new parent or leave current';
                        } else {
                            $except = [];
                            $first = 'None';
                        }

                        $field->options = Category::getSelectHierarchy('inquiries', $except, $first);

                        if ($parent && $parent->exists) {
                            $field->attributes([
                                'disabled' => true,
                            ]);
                        }
                    });

                $fieldset
                    ->control('input:text', 'name')
                    ->attributes([
                        'placeholder' => 'Name of the Category',
                    ]);

                $fieldset
                    ->control('input:checkbox', 'manager', function (Field $field) use ($category) {
                        $field->label = 'Manager Required?';

                        $attributes = [
                            'class' => 'switch-mark',
                        ];

                        if ($category->manager) {
                            $attributes['checked'] = true;
                        }

                        $field->value = true;

                        $field->attributes = $attributes;
                    });
            });
        });
    }

    /**
     * Returns a new navbar for the inquiry category index.
     *
     * @param Category|null $category
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Category $category = null)
    {
        return $this->fluent([
            'id'         => 'requests-categories',
            'title'      => 'Request Categories',
            'url'        => route('inquiries.categories.index'),
            'menu'       => view('pages.inquiries.categories._nav', compact('category')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
