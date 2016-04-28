<?php

namespace App\Http\Controllers;

use App\Http\Presenters\WelcomePresenter;
use App\Models\Guide;
use App\Models\Issue;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WelcomeController extends Controller
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
     * Show the application welcome screen to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $issue = $this->issue;

            if (! policy($this->issue)->viewAll($user)) {
                $issue = $issue->forUser($user);
            }

            $issues = $this->presenter->issues($issue);

            $services = $this->presenter->services($this->service);

            $guides = $this->presenter->guides($this->guide);
        }

        return view('pages.welcome.index', compact('issues', 'services', 'guides'));
    }
}
