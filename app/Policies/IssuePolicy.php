<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Issue;

class IssuePolicy extends Policy
{
    /**
     * Returns true / false if the specified user
     * can update the specified issue.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public function update(User $user, Issue $issue)
    {
        return $user->getKey() === $issue->user_id;
    }
}
