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
    public function viewUnpublished(User $user, Guide $guide = null)
    {
        if ($guide instanceof Guide && $guide->published) {
            return true;
        }

        return $user->can('guides.index.unpublished');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('guides.create');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @return bool
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->can('guides.edit');
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $this->edit($user);
    }

    /**
     * Allows only users with specific permission to delete guides.
     *
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->can('guides.destroy');
    }
}
