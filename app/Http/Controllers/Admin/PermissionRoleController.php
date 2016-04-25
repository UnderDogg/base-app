<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRoleRequest;
use App\Models\Permission;
use App\Models\Role;

class PermissionRoleController extends Controller
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
     * Adds the specified permission to the requested roles.
     *
     * @param PermissionRoleRequest $request
     * @param int|string            $permissionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionRoleRequest $request, $permissionId)
    {
        $this->authorize('admin.roles.permissions.store');

        $permission = $this->permission->findOrFail($permissionId);

        $roles = $request->input('roles', []);

        if (count($roles) > 0) {
            $roles = $this->role->findMany($roles);

            $permission->roles()->saveMany($roles);

            flash()->success('Success!', 'Successfully added roles.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }

        flash()->error('Error!', "You didn't select any roles!");

        return redirect()->route('admin.permissions.show', [$permissionId]);
    }

    /**
     * Removes the specified role from the specified permission.
     *
     * @param int|string $permissionId
     * @param int|string $roleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($permissionId, $roleId)
    {
        $this->authorize('admin.roles.permissions.destroy');

        $permission = $this->permission->findOrFail($permissionId);

        $role = $permission->roles()->findOrFail($roleId);

        if ($permission->roles()->detach($role)) {
            flash()->success('Success!', 'Successfully removed role.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }

        flash()->error('Error!', 'There was an issue removing this role. Please try again.');

        return redirect()->route('admin.permissions.show', [$permissionId]);
    }
}
