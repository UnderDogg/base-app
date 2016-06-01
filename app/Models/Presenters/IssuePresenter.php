<?php

namespace App\Models\Presenters;

use App\Models\Issue;
use App\Models\User;

class IssuePresenter
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
     * Returns an icon for the status of the issue.
     *
     * @return string
     */
    public function statusIcon()
    {
        if ($this->issue->isOpen()) {
            $class = 'text-success fa fa-exclamation-circle';
        } else {
            $class = 'text-danger fa fa-check-circle';
        }

        return "<i class='$class'></i>";
    }

    /**
     * Returns the tag line of the issue.
     *
     * @return string
     */
    public function tagLine()
    {
        $user = $this->issue->user->name;

        $daysAgo = $this->issue->created_at_human;

        $comments = count($this->issue->comments);

        $icon = '<i class="fa fa-comments"></i>';

        $hash = $this->issue->hash_id;

        $comments = "<span class='pull-right hidden-xs'>$icon $comments</span>";

        return "$hash opened $daysAgo by $user $comments";
    }

    /**
     * Returns the closed by user tag line.
     *
     * @return string
     */
    public function closedBy()
    {
        $user = $this->issue->closedByUser;

        $line = ($user instanceof User ? "Closed by {$user->name}" : "Closed");

        $daysAgo = $this->issue->closed_at_human;

        return "$line $daysAgo";
    }
}
