<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy
{
    /**
     * Returns true / false if the specified
     * user can view everyone's issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function viewAll(User $user)
    {
        return $user->can('issues.index.all');
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
    public static function show(User $user, Issue $issue)
    {
        return $user->can('issues.show') || $user->getKey() === $issue->user_id;
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
    public static function edit(User $user, Issue $issue)
    {
        return $user->can('issues.edit') || $user->getKey() === $issue->user_id;
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
    public static function update(User $user, Issue $issue)
    {
        return self::edit($user, $issue);
    }

    /**
     * Returns true / false if the specified user
     * can re-open issues.
     *
     * Only administrators can re-open issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function open(User $user)
    {
        return $user->can('issues.open');
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
    public static function close(User $user, Issue $issue)
    {
        return $user->can('issues.close') || $user->getKey() === $issue->user_id;
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
    public static function destroy(User $user, Issue $issue)
    {
        return $user->can('issues.destroy') || $user->getKey() === $issue->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can add labels to issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function addLabels(User $user)
    {
        return $user->can('issues.labels.store');
    }

    /**
     * Returns true / false if the specified user
     * can add users to issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function addUsers(User $user)
    {
        return $user->can('issues.users.store');
    }
}
