<?php

namespace App\Policies;

use Orchestra\Model\Role;
use App\Models\User;

class LabelPolicy extends Policy
{
    /**
     * Returns true / false if the specified user is
     * allowed to view the label index.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->is($this->admin()->name);
    }
}
