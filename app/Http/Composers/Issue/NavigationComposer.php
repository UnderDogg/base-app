<?php

namespace App\Http\Composers\Issue;

use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class NavigationComposer
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * Constructor.
     *
     * @param Issue $issue
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $open = $this->issue
            ->open()
            ->forUser(Auth::user())
            ->count();

        $closed = $this->issue
            ->closed()
            ->forUser(Auth::user())
            ->count();

        $view
            ->with('open', $open)
            ->with('closed', $closed);
    }
}
