<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class AccessPolicy
{
    /**
     * Returns true / false if the specified
     * user can access Active Directory
     * functionality.
     *
     * @param User $user
     *
     * @return bool
     */
    public function access(User $user)
    {
        return $user->can('ad.access');
    }
}
