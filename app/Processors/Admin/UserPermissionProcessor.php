<?php

namespace App\Processors\Admin;

use App\Http\Requests\Admin\UserPermissionRequest;
use App\Models\Permission;
use App\Models\User;
use App\Processors\Processor;

class UserPermissionProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Permission
     */
    protected $permission;

    /**
     * Constructor.
     *
     * @param User       $user
     * @param Permission $permission
     */
    public function __construct(User $user, Permission $permission)
    {
        $this->user = $user;
        $this->permission = $permission;
    }

    /**
     * Adds the requested permissions to the specified user.
     *
     * @param UserPermissionRequest $request
     * @param int|string            $userId
     *
     * @return array|false
     */
    public function store(UserPermissionRequest $request, $userId)
    {
        $this->authorize('admin.users.permissions.store');

        $user = $this->user->findOrFail($userId);

        $permissions = $request->input('permissions', []);

        if (count($permissions) > 0) {
            $permissions = $this->permission->findMany($permissions);

            return $user->permissions()->saveMany($permissions);
        }

        return false;
    }

    /**
     * Removes the specified permission from the specified user.
     *
     * @param int|string $userId
     * @param int|string $permissionId
     *
     * @return int
     */
    public function destroy($userId, $permissionId)
    {
        $this->authorize('admin.users.permissions.destroy');

        $user = $this->user->findOrFail($userId);

        $permission = $user->permissions()->findOrFail($permissionId);

        return $user->permissions()->detach($permission);
    }
}
