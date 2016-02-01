<?php

namespace App\Jobs\Issue;

use App\Jobs\Job;
use App\Models\Issue;

class Close extends Job
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
        if ($this->issue->isOpen()) {
            $this->issue->closed = true;
            $this->issue->closed_at = $this->issue->freshTimestamp();
            $this->issue->closed_by_user_id = auth()->id();

            return $this->issue->save();
        }

        return false;
    }
}
