<?php

namespace App\Policies;

use App\Models\User;

class IssueAttachmentPolicy
{
    /**
     * Returns true / false if the current user
     * can view issue attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function show(User $user)
    {
        return $user->can('issue.attachments.show');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('issues.attachments.edit');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function update(User $user)
    {
        return self::edit($user);
    }

    /**
     * Returns true / false if the current user
     * can delete issue attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('issues.attachments.destroy');
    }

    /**
     * Returns true / false if the current user
     * can download issue attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function download(User $user)
    {
        return $user->can('issues.attachments.download');
    }
}
