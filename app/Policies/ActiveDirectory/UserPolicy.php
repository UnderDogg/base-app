<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class UserPolicy
{
    /**
     * Returns true / false if the specified user
     * can view all active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('ad.users.index');
    }

    /**
     * Returns true / false if the specified user
     * can create active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('ad.users.create');
    }

    /**
     * Returns true / false if the specified user
     * can view active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function show(User $user)
    {
        return $user->can('ad.users.show');
    }

    /**
     * Returns true / false if the specified user
     * can edit active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('ad.users.edit');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function import(User $user)
    {
        return $user->can('ad.users.import');
    }
}
