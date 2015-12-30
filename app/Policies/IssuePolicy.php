<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Users Issues',
        'View Issue',
        'Edit Issue',
        'Open Issue',
        'Close Issue',
        'Delete Issue',
        'Add Labels',
        'Add Users',
    ];

    /**
     * Returns true / false if the specified
     * user can view everyones issues.
     *
     * @return bool
     */
    public function viewAll()
    {
        return $this->canIf('view-users-issues');
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
        return $this->canIf('view-issue') || $user->getKey() === $issue->user_id;
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
        return $this->canIf('edit-issue') || $user->getKey() === $issue->user_id;
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
        return $this->canIf('open-issue');
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
        return $this->canIf('close-issue') || $user->getKey() === $issue->user_id;
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
        return $this->canIf('delete-issue') || $user->getKey() === $issue->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can add labels to issues.
     *
     * @return bool
     */
    public function addLabels()
    {
        return $this->canIf('add-labels');
    }

    /**
     * Returns true / false if the specified user
     * can add users to issues.
     *
     * @return bool
     */
    public function addUsers()
    {
        return $this->canIf('add-users');
    }
}
