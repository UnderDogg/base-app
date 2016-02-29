<?php

namespace App\Policies;

use App\Models\User;

class AdminAccessPolicy
{
    /**
     * Returns true / false if the specified user
     * can access the backend administration.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('admin.welcome.index');
    }
}
