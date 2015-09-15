<?php

namespace App\Jobs;

use App\Models\Issue;
use Illuminate\Contracts\Bus\SelfHandling;

class OpenIssue extends Job implements SelfHandling
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
        $this->issue->closed = false;

        $this->issue->save();
    }
}
