<?php

namespace App\Processors\Admin;

use App\Exceptions\Admin\CannotRemoveRolesException;
use App\Http\Requests\Admin\RoleUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Processors\Processor;
use Illuminate\Database\Eloquent\Builder;

class RoleUserProcessor extends Processor
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
     * @return array|false
     */
    public function store(RoleUserRequest $request, $roleId)
    {
        $this->authorize('admin.roles.users.store');

        $role = $this->role->findOrFail($roleId);

        $users = $request->input('users', []);

        if (count($users) > 0) {
            $users = $this->user->findMany($users);

            return $role->users()->saveMany($users);
        }

        return false;
    }

    /**
     * Removes the specified user from the specified role.
     *
     * @param int|string $roleId
     * @param int|string $userId
     *
     * @throws CannotRemoveRolesException
     *
     * @return int
     */
    public function destroy($roleId, $userId)
    {
        $this->authorize('admin.roles.users.destroy');

        $role = $this->role->findOrFail($roleId);

        $user = $role->users()->findOrFail($userId);

        // Retrieve the administrators name.
        $adminName = Role::getAdministratorName();

        // Retrieve all administrators.
        $administrators = $this->user->whereHas('roles', function (Builder $builder) use ($adminName) {
            $builder->whereName($adminName);
        })->get();

        $admin = Role::whereName($adminName)->first();

        // We need to verify that if the user is trying to remove all roles on themselves,
        // and they are the only administrator, that we throw an exception notifying them
        // that they can't do that. Though we want to allow the user to remove the
        // administrator role if more than one administrator exists.
        if ($user->hasRole($admin)
            && $user->getKey() === auth()->user()->getKey()
            && count($administrators) === 1) {
            throw new CannotRemoveRolesException("Unable to remove the administrator role from this user. You're the only administrator.");
        }

        return $role->users()->detach($user);
    }
}
