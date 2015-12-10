<?php

namespace App\Jobs;

use App\Models\Issue;
use Illuminate\Contracts\Bus\SelfHandling;

class CloseIssue extends Job implements SelfHandling
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
     */
    public function handle()
    {
        $this->issue->closed = true;
        $this->issue->closed_at = $this->issue->freshTimestamp();

        $this->issue->save();
    }
}
