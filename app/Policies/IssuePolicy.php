<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    public function before(User $user)
    {
        return $user->can('manage.issues') ?: parent::before($user);
    }

    /**
     * Returns true / false if the specified
     * user can view everyone's issues.
     *
     * @return bool
     */
    public function viewAll()
    {
        return false;
    }

    /**
     * Returns true / false if the specified user
     * can view the specified issue.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public function show(User $user, Issue $issue)
    {
        return $user->id == $issue->user_id;
    }

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
        return $user->id == $issue->user_id;
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
        return $this->edit($user, $issue);
    }

    /**
     * Returns true / false if the specified user
     * can re-open issues.
     *
     * Only administrators can re-open issues.
     *
     * @return bool
     */
    public function open()
    {
        return false;
    }

    /**
     * Returns true / false if the specified user
     * can close issues.
     *
     * Only administrators / issue owners can close issues.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public function close(User $user, Issue $issue)
    {
        return $user->id == $issue->user_id;
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
        return $user->id == $issue->user_id;
    }
}
