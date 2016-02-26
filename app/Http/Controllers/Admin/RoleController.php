<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Admin\CannotDeleteAdministratorRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Processors\Admin\RoleProcessor;

class RoleController extends Controller
{
    /**
     * @var RoleProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param RoleProcessor $processor
     */
    public function __construct(RoleProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
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
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created role.');

            return redirect()->route('admin.roles.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a role. Please try again.');

            return redirect()->route('admin.roles.create');
        }
    }

    /**
     * Displays the specified role.
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return $this->processor->show($id);
    }

    /**
     * Displays the form for editing the specified role.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
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
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated role.');

            return redirect()->route('admin.roles.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this role. Please try again.');

            return redirect()->route('admin.roles.edit', [$id]);
        }
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
        try {
            if ($this->processor->destroy($id)) {
                flash()->success('Success!', 'Successfully deleted role.');

                return redirect()->route('admin.roles.index');
            } else {
                flash()->error('Error!', 'There was an issue deleting this role. Please try again.');

                return redirect()->route('admin.roles.show', [$id]);
            }
        } catch (CannotDeleteAdministratorRole $e) {
            flash()->setTimer(null)->error('Error!', $e->getMessage());

            return redirect()->route('admin.roles.show', [$id]);
        }
    }
}
