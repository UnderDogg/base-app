<?php

namespace App\Policies\ActiveDirectory;

use App\Models\User;

class ComputerPolicy
{
    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->can('ad.computers.index');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory computers.
     *
     * @return bool
     */
    public function store(User $user)
    {
        return $user->can('ad.computers.import');
    }

    /**
     * Returns true / false if the specified user
     * can add all active directory computers.
     *
     * @return bool
     */
    public function storeAll(User $user)
    {
        return $this->store($user);
    }
}
