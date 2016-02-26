<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    /**
     * Returns true / false if the current user can view all inquiries.
     *
     * @return bool
     */
    public function viewAll(User $user)
    {
        return $user->can('inquiries.index');
    }

    /**
     * Returns true / false if the specified user
     * can approve requests.
     *
     * @return bool
     */
    public function approve(User $user)
    {
        return $user->can('inquiries.approve');
    }

    /**
     * Returns true / false if the specified user
     * can re-open inquiries.
     *
     * Only administrators can re-open inquiries.
     *
     * @return bool
     */
    public function open(User $user)
    {
        return $user->can('inquiries.open');
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
        return $user->can('inquiries.close') || $user->getKey() === $inquiry->user_id;
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
        return $user->can('inquiries.show') || $user->getKey() === $inquiry->user_id;
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
        return $user->can('inquiries.edit') || $user->getKey() === $inquiry->user_id;
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
        return $user->can('inquiries.destroy') || $user->getKey() === $inquiry->user_id;
    }
}
