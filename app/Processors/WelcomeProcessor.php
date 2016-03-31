<?php

namespace App\Processors;

use App\Http\Presenters\WelcomePresenter;
use App\Models\Guide;
use App\Models\Issue;
use App\Models\Service;
use Illuminate\Contracts\Cache\Repository as Cache;

class WelcomeProcessor extends Processor
{
    /**
     * @var WelcomePresenter
     */
    protected $presenter;

    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @var Guide
     */
    protected $guide;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param WelcomePresenter $presenter
     * @param Issue            $issue
     * @param Service          $service
     * @param Guide            $guide
     * @param Cache            $cache
     */
    public function __construct(WelcomePresenter $presenter, Issue $issue, Service $service, Guide $guide, Cache $cache)
    {
        $this->presenter = $presenter;
        $this->issue = $issue;
        $this->service = $service;
        $this->guide = $guide;
        $this->cache = $cache;
    }

    /**
     * Displays the welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (auth()->check()) {
            $issues = $this->presenter->issues($this->issue);
        }

        $services = $this->presenter->services($this->service);

        $guides = $this->presenter->guides($this->guide);

        return view('pages.welcome.index', compact('issues', 'services', 'guides'));
    }
}
