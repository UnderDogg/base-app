<?php

namespace App\Http\Presenters\Issue;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Label;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Orchestra\Html\Table\Column;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Http\Presenters\Presenter;

class IssuePresenter extends Presenter
{
    /**
     * Returns a new Issue table.
     *
     * @param Issue|Builder $issue
     * @param array         $with
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($issue, array $with = ['users', 'labels'])
    {
        $issue = $this->applyPolicy($issue);

        $issue->with($with)->latest();

        return $this->table->of('issues', function (TableGrid $table) use ($issue) {
            $table->with($issue)->paginate($this->perPage);

            $table->attributes(['class' => 'table table-hover']);

            $table->sortable([
                'title',
                'description',
                'created_at',
            ]);

            $table->searchable([
                'title',
                'description',
            ]);

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
        $model = $this->applyPolicy($model);

        $issue = $model->with($with)->latest()->first();

        if ($issue instanceof Issue) {
            $column = new Column(['value' => $issue]);

            $column = $this->tableTitle($column);
        }

        return view('pages.issues._compact', compact('column', 'issue'));
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
                $form->setup($this, route('issues.update', [$issue->getKey()]), $issue, [
                    'method' => 'PATCH',
                ]);

                $form->submit = 'Save';
            } else {
                $form->setup($this, route('issues.store'), $issue, [
                    'method' => 'POST',
                ]);

                $form->submit = 'Create';
            }

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'title')
                    ->label('Title')
                    ->attributes(['placeholder' => 'Title']);

                $fieldset->control('input:text', 'occurred_at')
                    ->label('Occurred At')
                    ->attributes([
                        'class'       => 'date-picker',
                        'placeholder' => 'Click to select a date / time',
                    ])
                    ->value(function (Issue $issue) {
                        return $issue->occurredAtForInput();
                    });

                $fieldset->control('input:textarea', 'description')
                    ->label('Description')
                    ->attributes([
                        'placeholder'  => 'Leave a comment',
                        'data-provide' => 'markdown',
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
            $labels = Label::all()->lists('display', 'id');

            $form->setup($this, route('issues.labels.store', [$issue->getKey()]), $issue);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) use ($labels) {
                $fieldset->control('select', 'labels[]')
                    ->label('Labels')
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
                        'class'    => 'select-labels form-control',
                        'multiple' => true,
                    ]);
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
            $users = User::all()->lists('fullname', 'id');

            $form->setup($this, route('issues.users.store', [$issue->getKey()]), $issue);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) use ($users) {
                $fieldset->control('select', 'users[]')
                    ->label('Users')
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
                        'class'    => 'select-users form-control',
                        'multiple' => true,
                    ]);
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
            'id'         => 'issues',
            'title'      => 'Issues',
            'url'        => route('issues.index'),
            'menu'       => view('pages.issues._nav', compact('labels')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
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
        $column->label = 'Issue';

        $column->value = function (Issue $issue) {
            $link = link_to_route('issues.show', $issue->title, [$issue->getKey()]);

            $labels = [];
            $users = [];

            foreach ($issue->labels as $label) {
                /* @var \App\Models\Label $label */
                $labels[] = $label->getDisplay();
            }

            foreach ($issue->users as $user) {
                /* @var \App\Models\User $user */
                $users[] = $user->getLabel();
            }

            $labels = implode(null, $labels);
            $users = implode(null, $users);

            $tagLine = sprintf('<p class="h5 text-muted">%s</p>', $issue->getTagLine());

            return sprintf('%s %s %s %s', $link, $labels, $users, $tagLine);
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
        if ($issue instanceof Builder) {
            $model = $issue->getModel();
        } else {
            $model = $issue;
        }

        // Limit the view if the user isn't
        // allowed to view all issues.
        if (!policy($model)->viewAll(auth()->user())) {
            $issue->where('user_id', auth()->user()->getKey());
        }

        return $issue;
    }
}
