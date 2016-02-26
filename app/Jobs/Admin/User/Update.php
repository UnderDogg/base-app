<?php

namespace App\Jobs\Admin\User;

use App\Exceptions\Admin\CannotRemoveRolesException;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Update extends Job
{
    /**
     * @var UserRequest
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param UserRequest $request
     * @param User        $user
     */
    public function __construct(UserRequest $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @throws CannotRemoveRolesException
     *
     * @return bool
     */
    public function handle()
    {
        $this->user->name = $this->request->input('name', $this->user->name);
        $this->user->email = $this->request->input('email');

        $password = $this->request->input('password');

        // Verify before changing the users password that it's not empty.
        if (!empty($password)) {
            // If the user doesn't have a set password mutator,
            // we'll encrypt the password.
            if (!$this->user->hasSetMutator('password')) {
                $password = bcrypt($password);
            }

            $this->user->password = $password;
        }

        // Retrieve the administrators name.
        $adminName = Role::getAdministratorName();

        $roles = $this->request->input('roles', []);

        // Retrieve all administrator users.
        $administrators = $this->user->whereHas('roles', function (Builder $builder) use ($adminName) {
            $builder->whereName($adminName);
        })->get();

        // Retrieve the administrator role.
        $admin = Role::whereName($adminName)->first();

        // We need to verify that if the user is trying to remove all roles on themselves,
        // and they are the only administrator, that we throw an exception notifying them
        // that they can't do that. Though we want to allow the user to remove the
        // administrator role if more than one administrator exists.
        if (count($roles) === 0
            && $this->user->hasRole($admin)
            && $this->user->getKey() === auth()->user()->getKey()
            && count($administrators) === 1) {
            throw new CannotRemoveRolesException("Unable to remove the administrator role. You're the only administrator.");
        }

        if ($this->user->save()) {
            $this->user->roles()->sync($roles);

            return true;
        }

        return false;
    }
}
