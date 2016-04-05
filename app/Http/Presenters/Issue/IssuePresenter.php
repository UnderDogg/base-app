<?php

namespace App\Http\Presenters\Issue;

use App\Http\Presenters\Presenter;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Label;
use App\Models\User;
use App\Policies\IssuePolicy;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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
        $issue = $this->applyPolicy($issue);

        $label = request('label');
        $resolution = request('resolution');

        // Filter issues with the specified request label.
        $issue->with($with)->label($label)->hasResolution($resolution)->latest();

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
                    return $issue->status_icon;
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
     * Returns a new table of all open issues.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableOpen(Issue $issue)
    {
        $issue = $issue->where('closed', false);

        return $this->table($issue);
    }

    /**
     * Returns a new table of all closed issues.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableClosed(Issue $issue)
    {
        $issue = $issue->where('closed', true);

        return $this->table($issue);
    }

    /**
     * Displays the last created issue.
     *
     * @param Issue $model
     * @param array $with
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableLast(Issue $model, array $with = ['users', 'labels'])
    {
        return $this->table($model, $with, function (TableGrid $table, Issue $issue) {
            $issue = $issue->latest();

            $issue = $this->applyPolicy($issue);

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
            if ($issue->exists) {
                $url = route('issues.update', [$issue->getKey()]);
                $method = 'PATCH';

                $form->submit = 'Save';
            } else {
                $url = route('issues.store');
                $method = 'POST';

                $form->submit = 'Create';
            }

            $files = true;

            $form->with($issue);

            $form->attributes(compact('url', 'method', 'files'));

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

                // If the user can add labels we'll allow them to
                // add them during the creation of the ticket.
                if (IssuePolicy::addLabels(auth()->user())) {
                    $labels = Label::all()->pluck('display', 'id');

                    $this->labelField($fieldset, $labels);
                }

                // If the user can add users we'll allow them to
                // add them during the creation of the ticket.
                if (IssuePolicy::addUsers(auth()->user())) {
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
                        'class'         => 'editor',
                        'placeholder'   => 'Enter the description of the issue.',
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

            $form->setup($this, route('issues.labels.store', [$issue->getKey()]), $issue);

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

            $form->setup($this, route('issues.users.store', [$issue->getKey()]), $issue);

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
            'title'      => 'Tickets',
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
                'class'             => 'select-users form-control',
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
            $link = link_to_route('issues.show', $issue->title, [$issue->getKey()], [
                'class' => 'table-lead-title',
            ]);

            $labels = [];
            $users = [];

            foreach ($issue->labels as $label) {
                /* @var \App\Models\Label $label */
                $labels[] = $label->display;
            }

            foreach ($issue->users as $user) {
                /* @var \App\Models\User $user */
                $users[] = $user->label;
            }

            $labels = implode(null, $labels);
            $users = implode(null, $users);

            $tagLine = sprintf('<p class="h5 table-lead-summary">%s</p>', $issue->tag_line);

            return "$link $labels $users $tagLine";
        };

        return $column;
    }

    /**
     * Applies the issue policy to the issue query.
     *
     * @param Issue|Builder $issue
     *
     * @return Builder
     */
    protected function applyPolicy($issue)
    {
        // Limit the view if the user isn't
        // allowed to view all issues.
        if (!IssuePolicy::viewAll(auth()->user())) {
            $issue->where('user_id', auth()->user()->getKey());
        }

        return $issue;
    }
}
