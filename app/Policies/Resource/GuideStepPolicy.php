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
    public function index(User $user)
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
    public function create(User $user)
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
    public function edit(User $user)
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
    public function update(User $user)
    {
        return $this->edit($user);
    }

    /**
     * Allows users with specific permission
     * to create guide steps with images.
     *
     * @param User $user
     *
     * @return bool
     */
    public function images(User $user)
    {
        return $user->can('guides.steps.images.create');
    }

    /**
     * Allows users with specific permission
     * to move guide steps.
     *
     * @param User $user
     *
     * @return bool
     */
    public function move(User $user)
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
    public function destroy(User $user)
    {
        return $user->can('guides.steps.destroy');
    }
}
