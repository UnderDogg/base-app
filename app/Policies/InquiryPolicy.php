<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy extends Policy
{
    /**
     * The policy display name.
     *
     * @var string
     */
    protected $name = 'Requests';

    /**
     * The policy actions.
     *
     * @var array
     */
    public $actions = [
        'View Users Requests',
        'Open Requests',
        'Close Requests',
        'Approve Requests',
        'View Requests',
        'Edit Requests',
        'Delete Requests',
    ];

    /**
     * Returns true / false if the current user can view all inquiries.
     *
     * @return bool
     */
    public function viewAll()
    {
        return $this->canIf('view-users-requests');
    }

    /**
     * Returns true / false if the specified user
     * can approve requests.
     *
     * @return bool
     */
    public function approve()
    {
        return $this->canIf('approve-requests');
    }

    /**
     * Returns true / false if the specified user
     * can re-open inquiries.
     *
     * Only administrators can re-open inquiries.
     *
     * @return bool
     */
    public function open()
    {
        return $this->canIf('open-requests');
    }

    /**
     * Returns true / false if the specified user
     * can close inquiries.
     *
     * Only administrators / inquiry owners can close inquiries.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public function close(User $user, Inquiry $inquiry)
    {
        return $this->canIf('close-requests') || $user->getKey() === $inquiry->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can view the specified inquiry.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public function show(User $user, Inquiry $inquiry)
    {
        return $this->canIf('view-requests') || $user->getKey() === $inquiry->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can edit the specified inquiry.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public function edit(User $user, Inquiry $inquiry)
    {
        return $this->canIf('edit-requests') || $user->getKey() === $inquiry->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can update the specified inquiry.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public function update(User $user, Inquiry $inquiry)
    {
        return $this->edit($user, $inquiry);
    }

    /**
     * Returns true / false if the specified user
     * can delete the specified inquiry.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public function destroy(User $user, Inquiry $inquiry)
    {
        return $this->canIf('delete-requests') || $user->getKey() === $inquiry->user_id;
    }
}
