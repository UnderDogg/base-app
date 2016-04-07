<?php

namespace App\Http\Composers\Issue;

use App\Models\Issue;
use Illuminate\Contracts\View\View;

class NavigationComposer
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * Constructor.
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
        $view
            ->with('open', $this->issue->open()->count())
            ->with('closed', $this->issue->closed()->count());
    }
}
