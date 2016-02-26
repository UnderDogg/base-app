<?php

namespace App\Policies;

use App\Models\User;

class LabelPolicy
{
    /**
     * Allows users with specific permission
     * to view all labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->can('labels.index');
    }

    /**
     * Allows users with specific permission
     * to create labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('labels.create');
    }

    /**
     * Allows users with specific permission
     * to create labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * Allows users with specific permission
     * to edit labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->can('labels.edit');
    }

    /**
     * Allows users with specific permission
     * to update labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $this->edit($user);
    }

    /**
     * Allows users with specific permission
     * to delete labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->can('labels.destroy');
    }
}
