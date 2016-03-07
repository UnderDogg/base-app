<?php

namespace App\Http\Presenters\Inquiry;

use App\Http\Presenters\Presenter;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Inquiry;
use App\Models\User;
use App\Policies\InquiryPolicy;
use Illuminate\Database\Eloquent\Builder;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class InquiryPresenter extends Presenter
{
    /**
     * Returns a new table of all inquiries.
     *
     * @param Inquiry|Builder $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($inquiry)
    {
        $inquiry = $this->applyPolicy($inquiry->latest());

        return $this->table->of('inquiries', function (TableGrid $table) use ($inquiry) {
            $table->with($inquiry)->paginate($this->perPage);

            $table->searchable([
                'title',
            ]);

            $table->column('category', function (Column $column) {
                $column->label = 'Category';

                $column->value = function (Inquiry $inquiry) {
                    return $inquiry->category_label;
                };

                $column->attributes(function () {
                    return ['width' => '30'];
                });
            });

            $table->column('title', function (Column $column) {
                $column->value = function (Inquiry $inquiry) {
                    $link = link_to_route('inquiries.show', $inquiry->title, [$inquiry->getKey()]);

                    $tagLine = sprintf('<p class="h5 text-muted">%s</p>', $inquiry->tag_line);

                    return "$link $tagLine";
                };
            });

            $table->column('created', function (Column $column) {
                $column->value = function (Inquiry $inquiry) {
                    return $inquiry->created_at_human;
                };
            });
        });
    }

    /**
     * Returns a new table of all open inquiries.
     *
     * @param Inquiry $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableOpen(Inquiry $inquiry)
    {
        $inquiry = $inquiry->where('closed', false);

        return $this->table($inquiry);
    }

    /**
     * Returns a new table of all closed inquiries.
     *
     * @param Inquiry $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableClosed(Inquiry $inquiry)
    {
        $inquiry = $inquiry
            ->where('closed', true)
            ->where('approved', false);

        return $this->table($inquiry);
    }

    /**
     * Returns a new table of all approved inquiries.
     *
     * @param Inquiry $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableApproved(Inquiry $inquiry)
    {
        $inquiry = $inquiry->where('approved', true);

        return $this->table($inquiry);
    }

    /**
     * Returns a new table of all categories.
     *
     * @param Inquiry  $inquiry
     * @param Category $category
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableCategories(Inquiry $inquiry, Category $category)
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
                    return link_to_route('inquiries.start', $category->name, [$category->getKey()]);
                };
            });

            $table->column('select', function (Column $column) {
                $column->value = function (Category $category) {
                    $route = 'inquiries.create';

                    return link_to_route($route, 'Select This Category', [$category->getKey()], [
                        'class' => 'btn btn-success btn-sm',
                    ]);
                };
            });

            $table->column('sub-categories', function (Column $column) {
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->value = function (Category $category) {
                    return $category->children()->count();
                };

                $column->attributes = function ($row) {
                    return ['class' => 'hidden-xs'];
                };
            });
        });
    }

    /**
     * Returns a new form for the specified inquiry.
     *
     * @param Inquiry  $inquiry
     * @param Category $category
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Inquiry $inquiry, Category $category)
    {
        return $this->form->of('inquiries', function (FormGrid $form) use ($inquiry, $category) {
            if ($inquiry->exists) {
                $method = 'PATCH';
                $url = route('inquiries.update', [$inquiry->getKey()]);
                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('inquiries.store', [$category->getKey()]);
                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($inquiry);

            $form->fieldset(function (Fieldset $fieldset) use ($inquiry, $category) {
                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the title of your request.',
                    ]);

                if ($category->manager) {
                    $fieldset->control('input:select', 'manager', function (Field $field) use ($inquiry) {
                        $field->label = 'Manager';

                        $field->options = User::all()->pluck('name', 'id');

                        $field->value = function (Inquiry $inquiry) {
                            return $inquiry->manager_id;
                        };

                        if ($inquiry->category_id) {
                            $field->attributes = ['disabled'];
                        }
                    });
                }

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the description of your request.',
                    ]);
            });
        });
    }

    /**
     * Returns a new comment form.
     *
     * @param Inquiry $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formComment(Inquiry $inquiry)
    {
        $presenter = new InquiryCommentPresenter($this->form, $this->table);

        return $presenter->form($inquiry, (new Comment()));
    }

    /**
     * Returns a new navbar for the inquiry index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'requests',
            'title'      => 'Requests',
            'url'        => route('inquiries.index'),
            'menu'       => view('pages.inquiries._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }

    /**
     * Applies the issue policy to the issue query.
     *
     * @param Inquiry|Builder $inquiry
     *
     * @return Builder
     */
    protected function applyPolicy($inquiry)
    {
        // Limit the view if the user isn't
        // allowed to view all issues.
        if (!InquiryPolicy::viewAll(auth()->user())) {
            $inquiry->where('user_id', auth()->user()->getKey());
        }

        return $inquiry;
    }
}
