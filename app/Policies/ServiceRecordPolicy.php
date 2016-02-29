<?php

namespace App\Policies;

use App\Models\User;

class ServiceRecordPolicy
{
    /**
     * Returns true / false if the current user can view all services.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function index(User $user)
    {
        return $user->can('services.records.index');
    }

    /**
     * Returns true / false if the current user can create services.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function create(User $user)
    {
        return $user->can('services.records.create');
    }

    /**
     * Returns true / false if the current user can create services.
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
     * Returns true / false if the current user can view service records.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function show(User $user)
    {
        return $user->can('services.records.show');
    }

    /**
     * Returns true / false if the current user can edit services.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function edit(User $user)
    {
        return $user->can('services.records.edit');
    }

    /**
     * Returns true / false if the current user can edit services.
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
     * Returns true / false if the current user can delete services.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('services.records.destroy');
    }
}
