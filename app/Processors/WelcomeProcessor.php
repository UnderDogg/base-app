<?php

namespace App\Processors;

use Exception;
use Carbon\Carbon;
use App\Traits\CanPurifyTrait;
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
        $feeds = config('rss.feeds');

        $forecast = $this->feed($feeds['weather']);

        $articles = $this->feed($feeds['articles']);

        return view('pages.welcome.index', compact('forecast', 'articles'));
    }

    protected function feed($url)
    {
        $collection = new Collection();

        try {
            $feed = RSS::feed($url);

            if ($feed->articles instanceof Collection) {
                $parsed = $feed->articles->take(5)->each(function ($article) {
                    $date = Carbon::createFromTimestamp(strtotime($article->pubDate));

                    $article->description = $this->clean($article->description, [
                        'HTML.Allowed' => '',
                    ]);

                    $article->pubDate = $date->diffForHumans();
                });

                $collection = $collection->merge($parsed);
            }
        } catch (Exception $e) {
            // Articles could not be loaded.
        }


        return $collection;
    }
}
