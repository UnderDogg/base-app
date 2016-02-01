<?php

namespace App\Jobs\Issue;

use App\Models\Issue;
use App\Jobs\Job;

class Open extends Job
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
     * Closes an issue.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->issue->isClosed()) {
            $this->issue->closed = false;
            $this->issue->closed_at = null;
            $this->issue->closed_by_user_id = null;

            return $this->issue->save();
        }

        return false;
    }
}
