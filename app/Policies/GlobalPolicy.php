<?php

namespace App\Policies;

use App\Models\User;

class GlobalPolicy
{
    /**
     * Returns true / false if the specified user has access to the backend.
     *
     * @param User $user
     *
     * @return bool
     */
    public function backend(User $user)
    {
        if ($user->hasRole('administrator')) {
            return true;
        }

        return false;
    }
}
