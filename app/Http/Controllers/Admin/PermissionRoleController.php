<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRoleRequest;
use App\Processors\Admin\PermissionRoleProcessor;

class PermissionRoleController extends Controller
{
    /**
     * @var PermissionRoleProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PermissionRoleProcessor $processor
     */
    public function __construct(PermissionRoleProcessor $processor)
    {
        $this->processor = $processor;
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
        if ($this->processor->store($request, $permissionId)) {
            flash()->success('Success!', 'Successfully added roles.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        } else {
            flash()->error('Error!', "You didn't select any roles!");

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }
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
        if ($this->processor->destroy($permissionId, $roleId)) {
            flash()->success('Success!', 'Successfully removed role.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        } else {
            flash()->error('Error!', 'There was an issue removing this role. Please try again.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }
    }
}
