<?php

namespace App\Http\Composers\Layout;

use App\Models\Inquiry;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class NavigationComposer
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * Constructor.
     *
     * @param Issue   $issue
     * @param Inquiry $inquiry
     */
    public function __construct(Issue $issue, Inquiry $inquiry)
    {
        $this->issue = $issue;
        $this->inquiry = $inquiry;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = Auth::user();

        if ($user instanceof User) {
            // Open issues navigation badge count.
            $issues = $this->issue
                ->open()
                ->forUser(Auth::user())
                ->count();

            $view
                ->with('issues', $issues);
        }
    }
}
