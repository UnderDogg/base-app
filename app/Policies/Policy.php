<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

abstract class Policy
{
    /**
     * Bypasses all policy methods if the current user is an administrator.
     *
     * @param User $user
     *
     * @return bool
     */
    public function before(User $user)
    {
        return $user->hasRole(Role::getAdministratorName());
    }
}
