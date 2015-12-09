<?php

namespace App\Processors;

use Exception;
use Carbon\Carbon;
use App\Traits\CanPurifyTrait;
use Vinelab\Rss\Facades\RSS;
use Illuminate\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Cache\Repository as Cache;
use App\Http\Presenters\WelcomePresenter;

class WelcomeProcessor extends Processor
{
    use CanPurifyTrait;

    /**
     * @var WelcomePresenter
     */
    protected $presenter;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param WelcomePresenter $presenter
     * @param Cache            $cache
     */
    public function __construct(WelcomePresenter $presenter, Cache $cache)
    {
        $this->presenter = $presenter;
        $this->cache = $cache;
    }

    /**
     * Displays the welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $feeds = config('rss.feeds');

        $minutes = 30;

        $forecast = $this->cache->remember('feeds.weather', $minutes, function () use ($feeds) {
            return $this->feed($feeds['weather']);
        });

        $news =  $this->cache->remember('feeds.articles', $minutes, function () use ($feeds) {
            return $this->feed($feeds['articles']);
        });

        return view('pages.welcome.index', compact('forecast', 'news'));
    }

    /**
     * Creates a new RSS collection feed from the specified URL.
     *
     * @param string $url
     *
     * @return Fluent
     */
    protected function feed($url)
    {
        $fluent = new Fluent();

        $collection = new Collection();

        try {
            $feed = RSS::feed($url);

            if ($feed->articles instanceof Collection) {
                $articles = $feed->articles->take(5)->each(function ($article) {
                    $date = Carbon::createFromTimestamp(strtotime($article->pubDate));

                    // We'll clean the articles description of any HTML.
                    $article->description = $this->clean($article->description, [
                        'HTML.Allowed' => '',
                    ]);

                    // Reformat the publish date for clearer
                    // indication of how old the article is.
                    $article->pubDate = $date->diffForHumans();
                });

                $fluent->title = $feed->title;
                $fluent->link = $feed->link;
                $fluent->description = $feed->description;
                $fluent->articles =  $collection->merge($articles);
            }
        } catch (Exception $e) {
            // Articles could not be loaded.
        }

        return $fluent;
    }
}
