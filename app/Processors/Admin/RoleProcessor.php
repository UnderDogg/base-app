<?php

namespace App\Processors\Admin;

use App\Exceptions\Admin\CannotDeleteAdministratorRole;
use App\Http\Presenters\Admin\RolePresenter;
use App\Http\Requests\Admin\RoleRequest;
use App\Jobs\Admin\Role\Store;
use App\Jobs\Admin\Role\Update;
use App\Models\Role;
use App\Processors\Processor;

class RoleProcessor extends Processor
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * @var RolePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Role          $role
     * @param RolePresenter $presenter
     */
    public function __construct(Role $role, RolePresenter $presenter)
    {
        $this->role = $role;
        $this->presenter = $presenter;
    }

    /**
     * Displays all roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('admin.roles.index');

        $roles = $this->presenter->table($this->role);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Displays the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('admin.roles.create');

        $form = $this->presenter->form($this->role);

        return view('admin.roles.create', compact('form'));
    }

    /**
     * Creates a new role.
     *
     * @param RoleRequest $request
     *
     * @return bool
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('admin.roles.create');

        $role = $this->role->newInstance();

        return $this->dispatch(new Store($request, $role));
    }

    /**
     * Displays the specified role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this->authorize('admin.roles.show');

        $role = $this->role->with('users')->findOrFail($id);

        $users = $this->presenter->tableUsers($role);

        $formUsers = $this->presenter->formUsers($role);

        $permissions = $this->presenter->tablePermissions($role);

        $formPermissions = $this->presenter->formPermissions($role);

        return view('admin.roles.show', compact('role', 'users', 'formUsers', 'permissions', 'formPermissions'));
    }

    /**
     * Displays the form for editing the specified role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('admin.roles.edit');

        $role = $this->role->findOrFail($id);

        $form = $this->presenter->form($role);

        return view('admin.roles.edit', compact('form', 'role'));
    }

    /**
     * Updates the specified role.
     *
     * @param RoleRequest $request
     * @param int|string  $id
     *
     * @return bool
     */
    public function update(RoleRequest $request, $id)
    {
        $this->authorize('admin.roles.edit');

        $role = $this->role->findOrFail($id);

        return $this->dispatch(new Update($request, $role));
    }

    /**
     * Deletes the specified role.
     *
     * @param int|string $id
     *
     * @throws CannotDeleteAdministratorRole
     *
     * @return bool
     */
    public function destroy($id)
    {
        $this->authorize('admin.roles.destroy');

        $role = $this->role->findOrFail($id);

        if ($role->isAdministrator()) {
            throw new CannotDeleteAdministratorRole("You can't delete the administrator role.");
        }

        return $role->delete();
    }
}
