<?php

namespace App\Models\Observers;

use App\Models\Issue;

class IssueObserver extends Observer
{
    /**
     * Operations to run upon deleting an issue.
     *
     * @param Issue $issue
     */
    public function deleting(Issue $issue)
    {
        if (property_exists($issue, 'forceDeleting') && $issue->forceDeleting) {
            $issue->labels()->detach();
        }
    }
}
