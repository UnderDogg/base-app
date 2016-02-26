<?php

namespace App\Processors\Admin;

use App\Http\Presenters\Admin\PermissionPresenter;
use App\Http\Requests\Admin\PermissionRequest;
use App\Jobs\Admin\Permission\Store;
use App\Jobs\Admin\Permission\Update;
use App\Models\Permission;
use App\Processors\Processor;

class PermissionProcessor extends Processor
{
    /**
     * @var Permission
     */
    protected $permission;

    /**
     * @var PermissionPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Permission          $permission
     * @param PermissionPresenter $presenter
     */
    public function __construct(Permission $permission, PermissionPresenter $presenter)
    {
        $this->permission = $permission;
        $this->presenter = $presenter;
    }

    /**
     * Displays all permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('admin.permissions.index');

        $permissions = $this->presenter->table($this->permission);

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Displays the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('admin.permissions.create');

        $form = $this->presenter->form($this->permission);

        return view('admin.permissions.create', compact('form'));
    }

    /**
     * Creates a new permission.
     *
     * @param PermissionRequest $request
     *
     * @return bool
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize('admin.permissions.create');

        $permission = $this->permission->newInstance();

        return $this->dispatch(new Store($request, $permission));
    }

    /**
     * Displays the specified permission.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this->authorize('admin.permissions.show');

        $permission = $this->permission->findOrFail($id);

        $users = $this->presenter->tableUsers($permission);

        $formUsers = $this->presenter->formUsers($permission);

        $roles = $this->presenter->tableRoles($permission);

        $formRoles = $this->presenter->formRoles($permission);

        return view('admin.permissions.show', compact('permission', 'users', 'formUsers', 'roles', 'formRoles'));
    }

    /**
     * Displays the form for editing the specified permission.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('admin.permissions.edit');

        $permission = $this->permission->findOrFail($id);

        $form = $this->presenter->form($permission);

        return view('admin.permissions.edit', compact('form'));
    }

    /**
     * Updates the specified permission.
     *
     * @param PermissionRequest $request
     * @param int|string        $id
     *
     * @return bool
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->authorize('admin.permissions.edit');

        $permission = $this->permission->findOrFail($id);

        return $this->dispatch(new Update($request, $permission));
    }

    /**
     * Deletes the specified permission.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $this->authorize('admin.permissions.destroy');

        $permission = $this->permission->findOrFail($id);

        return $permission->delete();
    }
}
