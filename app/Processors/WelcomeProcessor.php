<?php

namespace App\Processors;

use App\Http\Presenters\WelcomePresenter;
use App\Models\Issue;
use App\Traits\CanPurifyTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Vinelab\Rss\Facades\RSS;

class WelcomeProcessor extends Processor
{
    use CanPurifyTrait;

    /**
     * @var WelcomePresenter
     */
    protected $presenter;

    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param WelcomePresenter $presenter
     * @param Issue            $issue
     * @param Cache            $cache
     */
    public function __construct(WelcomePresenter $presenter, Issue $issue, Cache $cache)
    {
        $this->presenter = $presenter;
        $this->issue = $issue;
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

        $weatherFeed = $feeds['weather'];
        $articleFeed = $feeds['articles'];

        $minutes = 30;

        $forecast = $this->cache->remember('feeds.weather', $minutes, function () use ($weatherFeed) {
            try {
                return $this->feed($weatherFeed);
            } catch (Exception $e) {
                return $this->cache->get('feeds.weather');
            }
        });

        $news = $this->cache->remember('feeds.articles', $minutes, function () use ($articleFeed) {
            try {
                return $this->feed($articleFeed);
            } catch (Exception $e) {
                return $this->cache->get('feeds.articles');
            }
        });

        if (auth()->check()) {
            $issues = $this->presenter->issue($this->issue);
        }

        return view('pages.welcome.index', compact('forecast', 'news', 'issues'));
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

        $feed = RSS::feed($url);

        if ($feed->articles instanceof Collection) {
            $articles = $feed->articles->take(5)->each(function ($article) {
                $cleaned = $this->clean($article->description, [
                    'HTML.Allowed' => '',
                ]);

                // We'll clean the articles description of any HTML.
                $article->description = str_limit($cleaned);

                $date = Carbon::createFromTimestamp(strtotime($article->pubDate));

                // Reformat the publish date for clearer
                // indication of how old the article is.
                $article->pubDate = $date->diffForHumans();
            });

            $fluent->title = $feed->title;
            $fluent->link = $feed->link;
            $fluent->description = $feed->description;
            $fluent->articles = $collection->merge($articles);
        }

        return $fluent;
    }
}
