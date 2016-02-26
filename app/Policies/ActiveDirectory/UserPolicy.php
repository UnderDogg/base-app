<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class UserPolicy
{
    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->can('ad.users.index');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory users.
     *
     * @param User $user
     *
     * @return bool
     */
    public function store(User $user)
    {
        return $user->can('ad.users.import');
    }
}
