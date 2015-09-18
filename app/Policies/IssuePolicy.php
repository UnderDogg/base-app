<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Issue;

class IssuePolicy extends Policy
{
    /**
     * Returns true / false if the specified user
     * can edit the specified issue.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public function edit(User $user, Issue $issue)
    {
        return $user->getKey() === $issue->user_id;
    }

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

    /**
     * Returns true / false if the specified user
     * can delete the specified issue.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public function destroy(User $user, Issue $issue)
    {
        return $user->getKey() === $issue->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can add labels to issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public function addLabels(User $user)
    {
        return $user->is(['Administrator']);
    }
}
