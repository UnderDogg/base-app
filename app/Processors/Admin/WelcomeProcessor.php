<?php

namespace App\Processors\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Processors\Processor;

class WelcomeProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

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
     * @param User       $user
     * @param Role       $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Displays the administration welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('admin.welcome.index');

        $users = $this->user->count();

        $roles = $this->role->count();

        $permissions = $this->permission->count();

        return view('admin.welcome.index', compact('users', 'roles', 'permissions'));
    }
}
