<?php

namespace App\Http\Presenters;

use App\Models\Issue;
use App\Http\Presenters\Issue\IssuePresenter;
use Illuminate\Support\Collection;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class WelcomePresenter extends Presenter
{
    /**
     * Returns a new table of all of the given articles.
     *
     * @param Collection $articles
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Collection $articles)
    {
        return $this->table->of('technology.feed', function (TableGrid $table) use ($articles) {
            $table->rows($articles->toArray());

            $table->attributes(['class' => 'table-hover']);

            $table->column('title')
                ->value(function ($article) {
                    return $article->title;
                });

            $table->column('description')
                ->value(function ($article) {
                    return str_limit($article->description);
                });
        });
    }

    /**
     * Displays the last issue created for the welcome page.
     *
     * @param Issue $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function issue(Issue $issue)
    {
        $presenter = new IssuePresenter($this->form, $this->table);

        return $presenter->tableLast($issue);
    }
}
