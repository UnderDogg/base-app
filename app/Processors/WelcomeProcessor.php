<?php

namespace App\Processors;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Vinelab\Rss\Facades\RSS;
use App\Http\Presenters\WelcomePresenter;

class WelcomeProcessor extends Processor
{
    /**
     * @var WelcomePresenter
     */
    protected $presenter;

    /**
     * The RSS url.
     *
     * @var string
     */
    protected $url = 'http://www.forbes.com/technology/index.xml';

    /**
     * Constructor.
     *
     * @param WelcomePresenter $presenter
     */
    public function __construct(WelcomePresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Displays the welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = new Collection();

        try {
            $feed = RSS::feed($this->url);

            if ($feed->articles instanceof Collection) {
                $parsed = $feed->articles->take(5)->each(function ($article) {
                    $date = Carbon::createFromTimestamp(strtotime($article->pubDate));

                    $article->pubDate = $date->diffForHumans();
                });

                $articles = $articles->merge($parsed);
            }
        } catch (Exception $e) {
            // Articles could not be loaded.
        }

        return view('pages.welcome.index', compact('articles'));
    }
}
