<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    /**
     * Returns true / false if the current user can view all inquiries.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function viewAll(User $user)
    {
        return $user->can('inquiries.index');
    }

    /**
     * Returns true / false if the specified user
     * can approve requests.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function approve(User $user)
    {
        return $user->can('inquiries.approve');
    }

    /**
     * Returns true / false if the specified user
     * can re-open inquiries.
     *
     * Only administrators can re-open inquiries.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function open(User $user)
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
    public static function close(User $user, Inquiry $inquiry)
    {
        return $user->can('inquiries.close') || $user->id === $inquiry->user_id;
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
    public static function show(User $user, Inquiry $inquiry)
    {
        return $user->can('inquiries.show') || $user->id === $inquiry->user_id;
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
    public static function edit(User $user, Inquiry $inquiry)
    {
        return $user->can('inquiries.edit') || $user->id === $inquiry->user_id;
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
    public static function update(User $user, Inquiry $inquiry)
    {
        return self::edit($user, $inquiry);
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
    public static function destroy(User $user, Inquiry $inquiry)
    {
        return $user->can('inquiries.destroy') || $user->id === $inquiry->user_id;
    }
}
