<?php

namespace App\Jobs;

use App\Models\Issue;

class CreateIssue extends Job
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
     * The labels to be attached to the issue upon creation.
     *
     * @var array
     */
    protected $labels = [];

    /**
     * The users to be attached to the issue upon creation.
     *
     * @var array
     */
    protected $users = [];

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $description
     * @param string $occurredAt
     * @param array  $labels
     * @param array  $users
     */
    public function __construct($title, $description, $occurredAt, array $labels = [], array $users = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->occurredAt = $occurredAt;
        $this->labels = $labels;
        $this->users = $users;
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

        if ($issue->save()) {
            // Sync the issues labels.
            $issue->labels()->sync($this->labels);

            // Sync the issues users.
            $issue->users()->sync($this->users);

            return true;
        }

        return false;
    }
}
