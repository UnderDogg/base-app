<?php

namespace App\Policies;

use App\Models\User;

class ServicePolicy
{
    /**
     * Returns true / false if the current user can view all services.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->can('services.index');
    }

    /**
     * Returns true / false if the current user can create services.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('services.create');
    }

    /**
     * Returns true / false if the current user can create services.
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
     * Returns true / false if the current user can view services.
     *
     * @param User $user
     *
     * @return bool
     */
    public function show(User $user)
    {
        return $user->can('services.show');
    }

    /**
     * Returns true / false if the current user can edit services.
     *
     * @param User $user
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->can('services.edit');
    }

    /**
     * Returns true / false if the current user can edit services.
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
     * Returns true / false if the current user can delete services.
     *
     * @param User $user
     *
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->can('services.destroy');
    }
}
