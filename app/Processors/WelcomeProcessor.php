<?php

namespace App\Processors;

use Exception;
use Carbon\Carbon;
use App\Traits\CanPurifyTrait;
use Vinelab\Rss\Feed;
use Vinelab\Rss\Facades\RSS;
use Illuminate\Support\Collection;
use App\Http\Presenters\WelcomePresenter;

class WelcomeProcessor extends Processor
{
    use CanPurifyTrait;

    /**
     * @var WelcomePresenter
     */
    protected $presenter;

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
        $feeds = config('rss.feeds');

        $forecast = $this->feed($feeds['weather']);

        $news = $this->feed($feeds['articles']);

        return view('pages.welcome.index', compact('forecast', 'news'));
    }

    /**
     * Creates a new RSS collection feed from the specified URL.
     *
     * @param string $url
     *
     * @return Feed
     */
    protected function feed($url)
    {
        try {
            $feed = RSS::feed($url);

            if ($feed->articles instanceof Collection) {
                $feed->articles->take(5)->each(function ($article) {
                    $date = Carbon::createFromTimestamp(strtotime($article->pubDate));

                    // We'll clean the articles description of any HTML.
                    $article->description = $this->clean($article->description, [
                        'HTML.Allowed' => '',
                    ]);

                    // Reformat the publish date for clearer
                    // indication of how old the article is.
                    $article->pubDate = $date->diffForHumans();
                });
            }
        } catch (Exception $e) {
            // Articles could not be loaded. Return an empty feed.
            $feed = new Feed(['item' => []]);
        }

        return $feed;
    }
}
