<?php

namespace App\Policies;

use App\Models\User;

class LabelPolicy
{
    /**
     * Returns true / false if the user can create labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('labels.create');
    }

    /**
     * Returns true / false if the user can edit labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('labels.edit');
    }

    /**
     * Returns true / false if the user can edit labels.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('labels.destroy');
    }
}
