<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;
use App\Policies\Policy as BasePolicy;

class Policy extends BasePolicy
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
        return $user->is($this->admin()->name);
    }
}
