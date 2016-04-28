<?php

namespace App\Http\Presenters;

use App\Http\Presenters\Issue\IssuePresenter;
use App\Http\Presenters\Resource\GuidePresenter;
use App\Http\Presenters\Service\ServicePresenter;
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
     * @param mixed $issue
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function issues($issue)
    {
        $presenter = new IssuePresenter($this->form, $this->table);
        
        return $presenter->tableLast($issue);
    }

    /**
     * Displays all of the services last status.
     *
     * @param mixed $service
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function services($service)
    {
        $presenter = new ServicePresenter($this->form, $this->table);

        return $presenter->tableStatus($service);
    }

    /**
     * Displays the last 5 created guides.
     *
     * @param mixed $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function guides($guide)
    {
        $presenter = new GuidePresenter($this->form, $this->table);

        return $presenter->tableLast($guide);
    }
}
