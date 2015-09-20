<?php

namespace App\Policies;

use Orchestra\Model\Role;

abstract class Policy
{
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
