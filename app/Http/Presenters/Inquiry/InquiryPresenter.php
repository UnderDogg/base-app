<?php

namespace App\Http\Presenters\Inquiry;

use App\Http\Presenters\Presenter;
use App\Models\Category;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Builder;
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
        $inquiry = $this->applyPolicy($inquiry);

        return $this->table->of('inquiries', function (TableGrid $table) use ($inquiry) {
            $table->with($inquiry)->paginate($this->perPage);

            $table->searchable([
                'title',
                'description',
            ]);

            $table->column('status', function (Column $column) {
                $column->label = '';

                $column->value = function (Inquiry $inquiry) {
                    return $inquiry->getStatusIcon();
                };

                $column->attributes(function () {
                    return ['width' => '30'];
                });
            });

            $table->column('title', function (Column $column) {
                $column->value = function (Inquiry $inquiry) {
                    return link_to_route('inquiries.show', $inquiry->title, [$inquiry->getKey()]);
                };
            });

            $table->column('description', function (Column $column) {
                $column->value = function (Inquiry $inquiry) {
                    return str_limit($inquiry->description, 20);
                };
            });

            $table->column('created', function (Column $column) {
                $column->value = function (Inquiry $inquiry) {
                    return $inquiry->createdAtHuman();
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
        $inquiry = $inquiry->where('closed', true);

        return $this->table($inquiry);
    }

    /**
     * Returns a new form for the specified inquiry.
     *
     * @param Inquiry $inquiry
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Inquiry $inquiry)
    {
        return $this->form->of('inquiries', function (FormGrid $form) use ($inquiry) {
            if ($inquiry->exists) {
                $method = 'PATCH';
                $url = route('inquiries.update', [$inquiry->getKey()]);
                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('inquiries.store');
                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($inquiry);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('select', 'category')
                    ->label('Request Category')
                    ->options(Category::getSelectHierarchy('inquiries'))
                    ->value(function (Inquiry $inquiry) {
                        if ($inquiry->category_id) {
                            return $inquiry->category_id;
                        }

                        return;
                    });

                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the title of your request.',
                    ]);

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the description of your request.',
                    ]);
            });
        });
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
        if ($inquiry instanceof Builder) {
            $model = $inquiry->getModel();
        } else {
            $model = $inquiry;
        }

        // Limit the view if the user isn't
        // allowed to view all issues.
        if (!policy($model)->viewAll(auth()->user())) {
            $inquiry->where('user_id', auth()->user()->getKey());
        }

        return $inquiry;
    }
}