<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUserRequest;
use App\Models\Role;
use App\Models\User;

class RoleUserController extends Controller
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Role $role
     * @param User $user
     */
    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Adds the requested users to the specified role.
     *
     * @param RoleUserRequest $request
     * @param int|string      $roleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleUserRequest $request, $roleId)
    {
        $this->authorize('admin.roles.users.store');

        $role = $this->role->findOrFail($roleId);

        $users = $request->input('users', []);

        if (count($users) > 0) {
            $users = $this->user->findMany($users);

            $role->users()->saveMany($users);

            flash()->success('Success!', 'Successfully added users.');

            return redirect()->route('admin.roles.show', [$roleId]);
        }

        flash()->error('Error!', "You didn't specify any users.");

        return redirect()->route('admin.roles.show', [$roleId]);
    }

    /**
     * Removes the specified user from the specified role.
     *
     * @param int|string $roleId
     * @param int|string $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($roleId, $userId)
    {
        $this->authorize('admin.roles.users.destroy');

        $role = $this->role->findOrFail($roleId);

        $user = $role->users()->findOrFail($userId);

        // Retrieve the administrators name.
        $adminName = Role::getAdministratorName();

        // Retrieve all administrators.
        $administrators = $this->user->whereHas('roles', function ($query) use ($adminName) {
            $query->whereName($adminName);
        })->get();

        $admin = Role::whereName($adminName)->first();

        // We need to verify that if the user is trying to remove all roles on themselves,
        // and they are the only administrator, that we throw an exception notifying them
        // that they can't do that. Though we want to allow the user to remove the
        // administrator role if more than one administrator exists.
        if ($user->hasRole($admin)
            && $user->id === auth()->user()->id
            && count($administrators) === 1) {
            flash()->setTimer(null)->error('Error!', "Unable to remove the administrator role from this user. You're the only administrator.");

            return redirect()->route('admin.roles.show', [$roleId]);
        }

        if ($role->users()->detach($user)) {
            flash()->success('Success!', 'Successfully removed user.');

            return redirect()->route('admin.roles.show', [$roleId]);
        }

        flash()->error('Error!', 'There was an issue removing this user. Please try again.');

        return redirect()->route('admin.roles.show', [$roleId]);
    }
}
