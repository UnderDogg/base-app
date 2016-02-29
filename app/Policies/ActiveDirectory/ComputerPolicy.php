<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class ComputerPolicy
{
    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('ad.computers.index');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory computers.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function import(User $user)
    {
        return $user->can('ad.computers.import');
    }

    /**
     * Returns true / false if the specified user
     * can add all active directory computers.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function importAll(User $user)
    {
        return self::store($user);
    }
}
