<?php

namespace App\Events\Issue;

use App\Events\Event;
use App\Models\Issue;

class Created extends Event
{
    /**
     * @var Issue
     */
    public $issue;

    /**
     * Created constructor.
     *
     * @param Issue $issue
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }
}
