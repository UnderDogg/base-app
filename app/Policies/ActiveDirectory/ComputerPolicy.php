<?php

namespace App\Policies\ActiveDirectory;

use Orchestra\Model\Role;
use App\Models\User;
use App\Policies\Policy;

class ComputerPolicy extends Policy
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
        return $user->is(Role::admin()->name);
    }
}
