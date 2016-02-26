<?php

namespace App\Processors\Admin;

use App\Http\Requests\Admin\PermissionRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Processors\Processor;

class PermissionRoleProcessor extends Processor
{
    /**
     * @var Permission
     */
    protected $permission;

    /**
     * @var Role
     */
    protected $role;

    /**
     * Constructor.
     *
     * @param Permission $permission
     * @param Role       $role
     */
    public function __construct(Permission $permission, Role $role)
    {
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * Adds the specified permission onto the requested roles.
     *
     * @param PermissionRoleRequest $request
     * @param int|string            $permissionId
     *
     * @return array|false
     */
    public function store(PermissionRoleRequest $request, $permissionId)
    {
        $this->authorize('admin.roles.permissions.store');

        $permission = $this->permission->findOrFail($permissionId);

        $roles = $request->input('roles', []);

        if (count($roles) > 0) {
            $roles = $this->role->findMany($roles);

            return $permission->roles()->saveMany($roles);
        }

        return false;
    }

    /**
     * Removes the specified permission from the specified role.
     *
     * @param int|string $permissionId
     * @param int|string $roleId
     *
     * @return int
     */
    public function destroy($permissionId, $roleId)
    {
        $this->authorize('admin.roles.permissions.destroy');

        $permission = $this->permission->findOrFail($permissionId);

        $role = $permission->roles()->findOrFail($roleId);

        return $permission->roles()->detach($role);
    }
}
