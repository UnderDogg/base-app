<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionUserRequest;
use App\Models\Permission;
use App\Models\User;

class PermissionUserController extends Controller
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
     * Adds the specified permission on the requested users.
     *
     * @param PermissionUserRequest $request
     * @param int|string            $permissionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionUserRequest $request, $permissionId)
    {
        $this->authorize('admin.users.permissions.store');

        $permission = $this->permission->findOrFail($permissionId);

        $users = $request->input('users', []);

        if (count($users) > 0) {
            $users = $this->user->findMany($users);

            $permission->users()->saveMany($users);

            flash()->success('Success!', 'Successfully added users.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }

        flash()->error('Error!', "You didn't select any users!");

        return redirect()->route('admin.permissions.show', [$permissionId]);
    }

    /**
     * Removes the specified permission from the specified user.
     *
     * @param int|string $permissionId
     * @param int|string $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($permissionId, $userId)
    {
        $this->authorize('admin.users.permissions.destroy');

        $permission = $this->permission->findOrFail($permissionId);

        $user = $permission->users()->findOrFail($userId);

        if ($permission->users()->detach($user)) {
            flash()->success('Success!', 'Successfully removed user.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }

        flash()->error('Error!', 'There was an issue removing this user. Please try again.');

        return redirect()->route('admin.permissions.show', [$permissionId]);
    }
}
