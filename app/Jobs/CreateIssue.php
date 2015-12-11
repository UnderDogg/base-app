<?php

namespace App\Jobs;

use App\Models\Issue;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateIssue extends Job implements SelfHandling
{
    /**
     * The issues title.
     *
     * @var string
     */
    protected $title;

    /**
     * The issues description.
     *
     * @var string
     */
    protected $description;

    /**
     * The issues occurred at date.
     *
     * @var string
     */
    protected $occurredAt;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $description
     * @param string $occurredAt
     */
    public function __construct($title, $description, $occurredAt)
    {
        $this->title = $title;
        $this->description = $description;
        $this->occurredAt = $occurredAt;
    }

    /**
     * Creates an issue.
     *
     * @param Issue $issue
     *
     * @return bool
     */
    public function handle(Issue $issue)
    {
        $issue->user_id = auth()->user()->getAuthIdentifier();
        $issue->title = $this->title;
        $issue->description = $this->description;
        $issue->occurred_at = $this->occurredAt;

        return $issue->save();
    }
}
