<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Processors\Admin\PermissionProcessor;

class PermissionController extends Controller
{
    /**
     * @var PermissionProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PermissionProcessor $processor
     */
    public function __construct(PermissionProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
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
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created permission.');

            return redirect()->route('admin.permissions.index');
        } else {
            flash()->error('Error!', 'There was an error creating a permission. Please try again.');

            return redirect()->route('admin.permissions.create');
        }
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
        return $this->processor->show($id);
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
        return $this->processor->edit($id);
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
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated permission.');

            return redirect()->route('admin.permissions.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an error updating this permission. Please try again.');

            return redirect()->route('admin.permissions.edit', [$id]);
        }
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
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted permission.');

            return redirect()->route('admin.permissions.index');
        } else {
            flash()->error('Error!', 'There was an error deleting this permission. Please try again.');

            return redirect()->route('admin.permissions.create');
        }
    }
}
