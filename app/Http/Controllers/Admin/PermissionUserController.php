<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionUserRequest;
use App\Processors\Admin\PermissionUserProcessor;

class PermissionUserController extends Controller
{
    /**
     * @var PermissionUserProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PermissionUserProcessor $processor
     */
    public function __construct(PermissionUserProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Adds the specified permission on the requested users.
     *
     * @param PermissionUserRequest $request
     * @param int|string            $permissionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionUserRequest $request, $permissionId)
    {
        if ($this->processor->store($request, $permissionId)) {
            flash()->success('Success!', 'Successfully added users.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        } else {
            flash()->error('Error!', "You didn't select any users!");

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }
    }

    /**
     * Removes the specified permission from the specified user.
     *
     * @param int|string $permissionId
     * @param int|string $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($permissionId, $userId)
    {
        if ($this->processor->destroy($permissionId, $userId)) {
            flash()->success('Success!', 'Successfully removed user.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        } else {
            flash()->error('Error!', 'There was an issue removing this user. Please try again.');

            return redirect()->route('admin.permissions.show', [$permissionId]);
        }
    }
}
