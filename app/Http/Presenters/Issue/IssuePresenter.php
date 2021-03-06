<?php

namespace App\Http\Presenters\Issue;

use App\Http\Presenters\Presenter;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Label;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class IssuePresenter extends Presenter
{
    /**
     * Returns a new Issue table.
     *
     * @param Issue|Builder $issue
     * @param array         $with
     * @param Closure       $closure
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($issue, array $with = ['users', 'labels'], Closure $closure = null)
    {
        $label = request('label');

        // Filter issues with the specified request label.
        $issue->with($with)->label($label)->latest();

        return $this->table->of('issues', function (TableGrid $table) use ($issue, $closure) {
            if ($closure instanceof Closure) {
                $table = call_user_func($closure, $table, $issue);
            } else {
                $table->with($issue)->paginate($this->perPage);
            }

            $table->sortable([
                'title',
                'description',
                'created_at',
            ]);

            $table->searchable([
                'title',
                'description',
            ]);

            $table->column('status', function (Column $column) {
                $column->label = '';

                $column->value = function (Issue $issue) {
                    return $issue->present()->statusIcon();
                };

                $column->attributes(function () {
                    return ['width' => '30'];
                });
            });

            $table->column('title', function (Column $column) {
                return $this->tableTitle($column);
            });
        });
    }

    /**
     * Displays the last created issue.
     *
     * @param mixed $model
     * @param array $with
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableLast($model, array $with = ['users', 'labels'])
    {
        return $this->table($model, $with, function (TableGrid $table, $issue) {
            $issue = $issue->latest();

            $table->with($issue)->paginate(1);

            $table->layout('pages.welcome._issue');

            return $table;
        });
    }

    /**
     * Returns a new Issue form.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form($issue)
    {
        return $this->form->of('issue', function (FormGrid $form) use ($issue) {
            $attributes = [
                'files' => true,
                'id'    => 'form-issue',
            ];

            if ($issue->exists) {
                $attributes['url'] = route('issues.update', [$issue->id]);
                $attributes['method'] = 'PATCH';

                $form->submit = 'Save';
            } else {
                $attributes['url'] = route('issues.store');
                $attributes['method'] = 'POST';

                $form->submit = 'Create';
            }

            $form->with($issue);
            $form->attributes($attributes);

            $form->fieldset(function (Fieldset $fieldset) use ($issue) {
                $fieldset->control('input:text', 'title')
                    ->label('Title')
                    ->attributes(['placeholder' => 'Enter a title that describes the issue in summary.']);

                $fieldset->control('input:text', 'occurred_at')
                    ->label('Occurred At')
                    ->attributes([
                        'class'       => 'date-picker',
                        'placeholder' => 'Click to select a date / time when the issue occured.',
                    ])
                    ->value(function (Issue $issue) {
                        return $issue->occurred_at_for_input;
                    });

                if (Auth::user()->can('manage.issues')) {
                    $labels = Label::all()->pluck('display', 'id');

                    $this->labelField($fieldset, $labels);

                    $labels = User::all()->pluck('name', 'id');

                    $this->userField($fieldset, $labels);
                }

                $fieldset->control('input:file', 'files[]', function (Field $field) use ($issue) {
                    if ($issue->files->count() > 0) {
                        $field->label = 'Add More Files';
                    } else {
                        $field->label = 'Attach Files';
                    }

                    $field->attributes = [
                        'multiple' => true,
                        'accept'   => '.xlx,.xlsx,.pdf,.doc,.docx,.jpg,.jpeg,.png',
                    ];
                });

                $fieldset->control('input:textarea', 'description')
                    ->label('Description')
                    ->attributes([
                        'placeholder' => 'Enter the description of the issue.',
                    ]);
            });
        });
    }

    /**
     * Returns a new issue comment form.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formComment(Issue $issue)
    {
        $presenter = new IssueCommentPresenter($this->form, $this->table);

        return $presenter->form($issue, (new Comment()));
    }

    /**
     * Returns a new issue labels form.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formLabels(Issue $issue)
    {
        return $this->form->of('issue.labels', function (FormGrid $form) use ($issue) {
            $labels = Label::all()->pluck('display', 'id');

            $form->attributes([
                'method'    => 'POST',
                'url'       => route('issues.labels.store', [$issue->id]),
            ]);

            $form->with($issue);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) use ($labels) {
                $this->labelField($fieldset, $labels);
            });

            $form->submit = 'Save';
        });
    }

    /**
     * Returns a new issue users form.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formUsers(Issue $issue)
    {
        return $this->form->of('issue.users', function (FormGrid $form) use ($issue) {
            $users = User::all()->pluck('name', 'id');

            $form->attributes([
                'method'    => 'POST',
                'url'       => route('issues.users.store', [$issue->id]),
            ]);

            $form->with($issue);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) use ($users) {
                $this->userField($fieldset, $users);
            });

            $form->submit = 'Save';
        });
    }

    /**
     * Returns a new navbar for the issue index.
     *
     * @param Collection $labels
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Collection $labels)
    {
        return $this->fluent([
            'id'         => 'tickets',
            'title'      => '<i class="fa fa-ticket"></i> Tickets',
            'url'        => route('issues.index'),
            'menu'       => view('pages.issues._nav', compact('labels')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }

    /**
     * Prepares a fieldset for the specified labels.
     *
     * @param Fieldset $fieldset
     * @param array    $labels
     *
     * @return mixed
     */
    protected function labelField(Fieldset $fieldset, $labels = [])
    {
        return $fieldset->control('select', 'labels[]')
            ->label('Add Labels')
            ->options($labels)
            ->value(function (Issue $issue) {
                $labels = [];

                $pivots = $issue->labels()->get();

                foreach ($pivots as $row) {
                    $labels[] = $row->id;
                }

                return $labels;
            })
            ->attributes([
                'class'             => 'select-labels form-control',
                'data-placeholder'  => 'Select Labels',
                'multiple'          => true,
            ]);
    }

    /**
     * Prepares a fieldset for the specified users.
     *
     * @param Fieldset $fieldset
     * @param array    $users
     *
     * @return mixed
     */
    protected function userField(Fieldset $fieldset, $users = [])
    {
        return $fieldset->control('select', 'users[]')
            ->label('Tag Users')
            ->options($users)
            ->value(function (Issue $issue) {
                $users = [];

                $pivots = $issue->users()->get();

                foreach ($pivots as $row) {
                    $users[] = $row->id;
                }

                return $users;
            })
            ->attributes([
                'class'             => 'select-multiple form-control',
                'data-placeholder'  => 'Select Users',
                'multiple'          => true,
            ]);
    }

    /**
     * Modifies and returns the table title column.
     *
     * @param Column $column
     *
     * @return Column
     */
    protected function tableTitle(Column $column)
    {
        $column->label = 'Ticket';

        $column->value = function (Issue $issue) {
            $link = link_to_route('issues.show', $issue->title, [$issue->id], [
                'class' => 'table-lead-title',
            ]);

            $labels = [];
            $users = [];

            foreach ($issue->labels as $label) {
                $labels[] = $label->display;
            }

            foreach ($issue->users as $user) {
                $users[] = $user->present()->label();
            }

            $labels = implode(null, $labels);
            $users = implode(null, $users);

            $tagLine = sprintf('<p class="h6 table-lead-summary">%s</p>', $issue->present()->tagLine());

            return "$link $labels $users $tagLine";
        };

        return $column;
    }
}
