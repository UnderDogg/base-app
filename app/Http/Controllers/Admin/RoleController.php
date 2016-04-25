<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Admin\RolePresenter;
use App\Http\Requests\Admin\RoleRequest;
use App\Jobs\Admin\Role\Store;
use App\Jobs\Admin\Role\Update;
use App\Models\Role;

class RoleController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('admin.roles.create');

        $role = $this->role->newInstance();

        if ($this->dispatch(new Store($request, $role))) {
            flash()->success('Success!', 'Successfully created role.');

            return redirect()->route('admin.roles.index');
        }

        flash()->error('Error!', 'There was an issue creating a role. Please try again.');

        return redirect()->route('admin.roles.create');
    }

    /**
     * Displays the specified role.
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {

        $this->authorize('admin.roles.edit');

        $role = $this->role->findOrFail($id);

        if ($this->dispatch(new Update($request, $role))) {
            flash()->success('Success!', 'Successfully updated role.');

            return redirect()->route('admin.roles.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue updating this role. Please try again.');

        return redirect()->route('admin.roles.edit', [$id]);
    }

    /**
     * Deletes the specified role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('admin.roles.destroy');

        $role = $this->role->findOrFail($id);

        if ($role->isAdministrator()) {
            flash()->setTimer(null)->error('Error!', "You can't delete the administrator role.");

            return redirect()->route('admin.roles.show', [$id]);
        }

        if ($role->delete()) {
            flash()->success('Success!', 'Successfully deleted role.');

            return redirect()->route('admin.roles.index');
        }

        flash()->error('Error!', 'There was an issue deleting this role. Please try again.');

        return redirect()->route('admin.roles.show', [$id]);
    }
}
