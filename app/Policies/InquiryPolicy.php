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
    protected $name = 'Inquiry Policy';

    /**
     * The policy actions.
     *
     * @var array
     */
    public $actions = [
        'View Users Inquiries',
        'View Inquiry',
        'Edit Inquiry',
        'Delete Inquiry',
    ];

    /**
     * Returns true / false if the current user can view all inquiries.
     *
     * @return bool
     */
    public function viewAll()
    {
        return $this->canIf('view-users-inquiries');
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
        return $this->canIf('view-inquiry') || $user->getKey() === $inquiry->user_id;
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
        return $this->canIf('edit-inquiry') || $user->getKey() === $inquiry->user_id;
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
        return $this->canIf('delete-inquiry') || $user->getKey() === $inquiry->user_id;
    }
}
