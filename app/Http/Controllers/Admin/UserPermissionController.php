<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPermissionRequest;
use App\Models\Permission;
use App\Models\User;

class UserPermissionController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserPermissionRequest $request, $userId)
    {
        $this->authorize('admin.users.permissions.store');

        $user = $this->user->findOrFail($userId);

        $permissions = $request->input('permissions', []);

        if (count($permissions) > 0) {
            $permissions = $this->permission->findMany($permissions);

            $user->permissions()->saveMany($permissions);

            flash()->success('Success!', 'Successfully added permissions.');

            return redirect()->route('admin.users.show', [$userId]);
        }

        flash()->error('Error!', "You didn't select any permissions.");

        return redirect()->route('admin.users.show', [$userId]);
    }

    /**
     * Removes the specified permission from the specified user.
     *
     * @param int|string $userId
     * @param int|string $permissionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userId, $permissionId)
    {
        $this->authorize('admin.users.permissions.destroy');

        $user = $this->user->findOrFail($userId);

        $permission = $user->permissions()->findOrFail($permissionId);

        if ($user->permissions()->detach($permission)) {
            flash()->success('Success!', 'Successfully removed permission.');

            return redirect()->route('admin.users.show', [$userId]);
        }

        flash()->error('Error!', 'There was an issue removing this permission. Please try again.');

        return redirect()->route('admin.users.show', [$userId]);
    }
}
