<?php

namespace App\Policies;

use App\Models\User;
use Orchestra\Model\Role;

abstract class Policy
{
    /**
     * Intercepts all checks and allows administrators
     * to perform all tasks.
     *
     * @param User $user
     *
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->is($this->admin()->name)) {
            return true;
        }
    }

    /**
     * Returns the administrators role.
     *
     * @return null|Role
     */
    public function admin()
    {
        return Role::admin();
    }
}
