<?php

namespace App\Processors\Admin;

use App\Http\Requests\Admin\PermissionUserRequest;
use App\Models\Permission;
use App\Models\User;
use App\Processors\Processor;

class PermissionUserProcessor extends Processor
{
    /**
     * @var Permission
     */
    protected $permission;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Permission $permission
     * @param User       $user
     */
    public function __construct(Permission $permission, User $user)
    {
        $this->permission = $permission;
        $this->user = $user;
    }

    /**
     * Adds the specified permission to the requested users.
     *
     * @param PermissionUserRequest $request
     * @param int|string            $permissionId
     *
     * @return array|false
     */
    public function store(PermissionUserRequest $request, $permissionId)
    {
        $this->authorize('admin.users.permissions.store');

        $permission = $this->permission->findOrFail($permissionId);

        $users = $request->input('users', []);

        if (count($users) > 0) {
            $users = $this->user->findMany($users);

            return $permission->users()->saveMany($users);
        }

        return false;
    }

    /**
     * Removes the specified permission from the specified user.
     *
     * @param int|string $permissionId
     * @param int|string $userId
     *
     * @return int
     */
    public function destroy($permissionId, $userId)
    {
        $this->authorize('admin.users.permissions.destroy');

        $permission = $this->permission->findOrFail($permissionId);

        $user = $permission->users()->findOrFail($userId);

        return $permission->users()->detach($user);
    }
}
