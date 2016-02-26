<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    /**
     * Returns true / false if the current user can view all categories.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->can('categories.index');
    }

    /**
     * Returns true / false if the current user can edit categories.
     *
     * @param User $user
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->can('categories.edit');
    }

    /**
     * Returns true / false if the current user can update categories.
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
     * Returns true / false if the current user can delete categories.
     *
     * @param User $user
     *
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->can('categories.destroy');
    }
}
