<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Admin\PermissionPresenter;
use App\Http\Requests\Admin\PermissionRequest;
use App\Jobs\Admin\Permission\Store;
use App\Jobs\Admin\Permission\Update;
use App\Models\Permission;

class PermissionController extends Controller
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
     * Creates a permission.
     *
     * @param PermissionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize('admin.permissions.create');

        $permission = $this->permission->newInstance();

        if ($this->dispatch(new Store($request, $permission))) {
            flash()->success('Success!', 'Successfully created permission.');

            return redirect()->route('admin.permissions.index');
        }

        flash()->error('Error!', 'There was an error creating a permission. Please try again.');

        return redirect()->route('admin.permissions.create');
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->authorize('admin.permissions.edit');

        $permission = $this->permission->findOrFail($id);

        if ($this->dispatch(new Update($request, $permission))) {
            flash()->success('Success!', 'Successfully updated permission.');

            return redirect()->route('admin.permissions.show', [$id]);
        }

        flash()->error('Error!', 'There was an error updating this permission. Please try again.');

        return redirect()->route('admin.permissions.edit', [$id]);
    }

    /**
     * Deletes the specified permission.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('admin.permissions.destroy');

        $permission = $this->permission->findOrFail($id);

        if ($permission->delete()) {
            flash()->success('Success!', 'Successfully deleted permission.');

            return redirect()->route('admin.permissions.index');
        }
        
        flash()->error('Error!', 'There was an error deleting this permission. Please try again.');

        return redirect()->route('admin.permissions.create');
    }
}
