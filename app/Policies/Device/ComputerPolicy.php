<?php

namespace App\Policies\Device;

use App\Models\User;

class ComputerPolicy
{
    /**
     * Determines if the current user can view all computers.
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('computers.index');
    }

    /**
     * Determines if the current user can create computers.
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('computers.create');
    }

    /**
     * Determines if the current user can store computers.
     *
     * @return bool
     */
    public static function store(User $user)
    {
        return self::create($user);
    }

    /**
     * Determines if the current user can view computers.
     *
     * @return bool
     */
    public static function show(User $user)
    {
        return $user->can('computers.show');
    }

    /**
     * Determines if the current user can edit computers.
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('computers.edit');
    }

    /**
     * Determines if the current user can update computers.
     *
     * @return bool
     */
    public static function update(User $user)
    {
        return self::edit($user);
    }

    /**
     * Determines if the current user can destroy computers.
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('computers.destroy');
    }
}
