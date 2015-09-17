<?php

namespace App\Http\Presenters;

use App\Models\Label;
use App\Models\Issue;
use Orchestra\Support\Facades\HTML;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class IssuePresenter extends Presenter
{
    /**
     * Returns a new Issue table.
     *
     * @param Issue $issue
     * @param bool  $closed
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($issue, $closed = false)
    {
        $issue = $issue->where(compact('closed'))->latest();

        return $this->table->of('issues', function (TableGrid $table) use ($issue) {
            $table->with($issue, true);

            $table->sortable([
                'title',
                'description',
            ]);

            $table->column('title', function ($column) {
                $column->label = 'Issue';

                $column->value = function (Issue $issue) {
                    $link = link_to_route('issues.show', $issue->title, [$issue->getKey()]);

                    $labels = [];

                    foreach($issue->labels as $label) {
                        $labels[] = $label->display();
                    }

                    $labels = implode(null, $labels);

                    $tagLine = HTML::create('p', $issue->tagLine(), ['class' => 'h5 text-muted']);

                    return sprintf('%s %s %s', $link, $labels, $tagLine);
                };
            });
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
            if($issue->exists) {
                $form->setup($this, route('issues.update', [$issue->getKey()]), $issue, [
                    'method' => 'PATCH',
                ]);
            } else {
                $form->setup($this, route('issues.store'), $issue, [
                    'method' => 'POST',
                ]);
            }

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'title')
                    ->label('Title')
                    ->attributes(['placeholder' => 'Title']);

                $fieldset->control('input:textarea', 'description')
                    ->label('Description')
                    ->attributes([
                        'placeholder' => 'Leave a comment',
                        'data-provide' => 'markdown',
                        'data-hidden-buttons' => '["cmdUrl","cmdImage"]',
                    ]);
            });

            $form->submit = 'Save';
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
        return $this->form->of('issue.comment', function (FormGrid $form) use ($issue)
        {
            $form->setup($this, route('issues.comments.store', [$issue->getKey()]), $issue);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:textarea', 'content')
                    ->label('Comment')
                    ->attributes([
                        'placeholder' => 'Leave a comment',
                        'data-provide' => 'markdown',
                    ]);
            });

            $form->submit = 'Comment';
        });
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
        return $this->form->of('issue.labels', function (FormGrid $form) use ($issue)
        {
            $labels = Label::all()->lists('display', 'id');

            $form->setup($this, 'url', $issue);

            $form->layout('components.form-modal');

            $form->fieldset(function (Fieldset $fieldset) use ($labels) {

                $fieldset->control('select', 'labels')
                    ->label('Labels')
                    ->options($labels)
                    ->value(function(Issue $issue) {
                        $labels = [];

                        $pivots = $issue->labels()->get();

                        foreach($pivots as $row) {
                            $labels[] = $row->id;
                        }

                        return $labels;
                    })
                    ->attributes([
                        'class' => 'select-labels form-control',
                        'multiple' => true,
                    ]);
            });

            $form->submit = 'Save';
        });
    }
}
