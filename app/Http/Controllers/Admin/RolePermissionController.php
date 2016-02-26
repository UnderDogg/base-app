<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolePermissionRequest;
use App\Processors\Admin\RolePermissionProcessor;

class RolePermissionController extends Controller
{
    /**
     * @var RolePermissionProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param RolePermissionProcessor $processor
     */
    public function __construct(RolePermissionProcessor $processor)
    {
        $this->processor = $processor;
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
        if ($this->processor->store($request, $roleId)) {
            flash()->success('Success!', 'Successfully added permissions.');

            return redirect()->route('admin.roles.show', [$roleId]);
        } else {
            flash()->error('Error!', "You didn't select any permissions.");

            return redirect()->route('admin.roles.show', [$roleId]);
        }
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
        if ($this->processor->destroy($roleId, $permissionId)) {
            flash()->success('Success!', 'Successfully removed permission.');

            return redirect()->route('admin.roles.show', [$roleId]);
        } else {
            flash()->error('Error!', 'There was an issue removing this permission. Please try again.');

            return redirect()->route('admin.roles.show', [$roleId]);
        }
    }
}
