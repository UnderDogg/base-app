<?php

namespace App\Http\Composers\Issue;

use App\Models\Issue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $open = $this->issue->open();
        $closed = $this->issue->closed();

        if ($user->can('manage.issues')) {
            // If the user doesn't have permission to view all issues, we
            // need to scope the query by the current user to only
            // show the users issue count.
            $open->forUser($user);
            $closed->forUser($user);
        }

        $open = $open->count();
        $closed = $closed->count();

        $view
            ->with('open', $open)
            ->with('closed', $closed);
    }
}
