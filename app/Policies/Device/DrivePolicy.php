<?php

namespace App\Policies\Device;

use App\Models\User;

class DrivePolicy
{
    /**
     * Returns true / false if the specified user can view all drives.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('drives.index');
    }

    /**
     * Returns true / false if the specified user can create drives.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('drives.create');
    }

    /**
     * Returns true / false if the specified user can edit drives.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('drives.edit');
    }

    /**
     * Returns true / false if the specified user can delete drives.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('drives.destroy');
    }
}
