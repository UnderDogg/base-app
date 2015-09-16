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
     * Constructor.
     *
     * @param string $title
     * @param string $description
     */
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
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

        return $issue->save();
    }
}
