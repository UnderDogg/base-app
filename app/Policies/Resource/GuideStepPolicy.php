<?php

namespace App\Policies\Resource;

use App\Models\User;

class GuideStepPolicy
{
    /**
     * Allows users with specific permission
     * to view all guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('guides.steps.index');
    }

    /**
     * Allows users with specific permission
     * to create guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('guides.steps.create');
    }

    /**
     * Allows users with specific permission
     * to edit guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('guides.steps.edit');
    }

    /**
     * Allows users with specific permission
     * to update guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function update(User $user)
    {
        return self::edit($user);
    }

    /**
     * Allows users with specific permission
     * to create guide steps with images.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function images(User $user = null)
    {
        if ($user instanceof User) {
            return $user->can('guides.steps.images.create');
        }

        return false;
    }

    /**
     * Allows users with specific permission
     * to move guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function move(User $user)
    {
        return $user->can('guides.steps.move');
    }

    /**
     * Allows users with specific permission
     * to delete guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('guides.steps.destroy');
    }
}
