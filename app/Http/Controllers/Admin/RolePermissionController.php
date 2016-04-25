<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolePermissionRequest;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * @var Permission
     */
    protected $permission;

    /**
     * Constructor.
     *
     * @param Role       $role
     * @param Permission $permission
     */
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Adds the requested permissions to the specified role.
     *
     * @param RolePermissionRequest $request
     * @param int|string            $roleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RolePermissionRequest $request, $roleId)
    {
        $this->authorize('admin.roles.permissions.store');

        $role = $this->role->findOrFail($roleId);

        $permissions = $request->input('permissions', []);

        if (count($permissions) > 0) {
            $permissions = $this->permission->findMany($permissions);

            $role->permissions()->saveMany($permissions);

            flash()->success('Success!', 'Successfully added permissions.');

            return redirect()->route('admin.roles.show', [$roleId]);
        }

        flash()->error('Error!', "You didn't select any permissions.");

        return redirect()->route('admin.roles.show', [$roleId]);
    }

    /**
     * Removes the specified permission from the specified role.
     *
     * @param int|string $roleId
     * @param int|string $permissionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($roleId, $permissionId)
    {
        $this->authorize('admin.roles.permissions.destroy');

        $role = $this->role->findOrFail($roleId);

        $permission = $role->permissions()->findOrFail($permissionId);

        if ($role->permissions()->detach($permission)) {
            flash()->success('Success!', 'Successfully removed permission.');

            return redirect()->route('admin.roles.show', [$roleId]);
        }

        flash()->error('Error!', 'There was an issue removing this permission. Please try again.');

        return redirect()->route('admin.roles.show', [$roleId]);
    }
}
