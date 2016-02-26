<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'Tickets';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Users Tickets',
        'View Ticket',
        'Edit Ticket',
        'Open Ticket',
        'Close Ticket',
        'Delete Ticket',
        'Add Ticket',
        'Add Ticket',
    ];

    /**
     * Returns true / false if the specified
     * user can view everyone's issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAll(User $user)
    {
        return $user->can('issue.index.all');
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
        return $user->can('issue.show') || $user->getKey() === $issue->user_id;
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
        return $user->can('issue.edit') || $user->getKey() === $issue->user_id;
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
     * @param User $user
     *
     * @return bool
     */
    public function open(User $user)
    {
        return $user->can('issue.open');
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
        return $user->can('issue.close') || $user->getKey() === $issue->user_id;
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
        return $user->can('issue.destroy') || $user->getKey() === $issue->user_id;
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
        return $user->can('issue.labels.store');
    }

    /**
     * Returns true / false if the specified user
     * can add users to issues.
     *
     * @param User $user
     *
     * @return bool
     */
    public function addUsers(User $user)
    {
        return $user->can('issue.users.store');
    }
}
