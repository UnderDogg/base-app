<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class UserPolicy
{
    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
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
     * @return bool
     */
    public function store(User $user)
    {
        return $user->can('ad.users.import');
    }
}
