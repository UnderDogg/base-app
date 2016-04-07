<?php

namespace App\Policies\Resource;

use App\Models\Guide;
use App\Models\User;

class GuidePolicy
{
    /**
     * Allows only users with specific permission
     * to view guides that are unpublished.
     *
     * @param User       $user
     * @param Guide|null $guide
     *
     * @return bool
     */
    public static function viewUnpublished(User $user, Guide $guide = null)
    {
        if ($guide instanceof Guide && $guide->published) {
            return true;
        }

        return $user->can('guides.index.unpublished');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('guides.create');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function store(User $user)
    {
        return self::create($user);
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('guides.edit');
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function update(User $user)
    {
        return static::edit($user);
    }

    /**
     * Allows only users with specific permission to delete guides.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('guides.destroy');
    }
}
