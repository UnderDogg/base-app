<?php

namespace App\Http\Composers\Layout;

use App\Models\Inquiry;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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

        // Check for the user instance due to the layout
        // navigation being composed by guests as well.
        if ($user instanceof User) {
            $query = $issues = $this->issue->open();

            if ($user->cannot('manage.issues')) {
                $query = $query->forUser($user);
            }

            $issues = $query->count();

            $view
                ->with('issues', $issues);
        }
    }
}
