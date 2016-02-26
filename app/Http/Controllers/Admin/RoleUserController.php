<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Admin\CannotRemoveRolesException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUserRequest;
use App\Processors\Admin\RoleUserProcessor;

class RoleUserController extends Controller
{
    /**
     * @var RoleUserProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param RoleUserProcessor $processor
     */
    public function __construct(RoleUserProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Adds the requested users to the specified role.
     *
     * @param RoleUserRequest $request
     * @param int|string      $roleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleUserRequest $request, $roleId)
    {
        if ($this->processor->store($request, $roleId)) {
            flash()->success('Success!', 'Successfully added users.');

            return redirect()->route('admin.roles.show', [$roleId]);
        } else {
            flash()->error('Error!', "You didn't specify any users.");

            return redirect()->route('admin.roles.show', [$roleId]);
        }
    }

    /**
     * Removes the specified user from the specified role.
     *
     * @param int|string $roleId
     * @param int|string $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($roleId, $userId)
    {
        try {
            if ($this->processor->destroy($roleId, $userId)) {
                flash()->success('Success!', 'Successfully removed user.');

                return redirect()->route('admin.roles.show', [$roleId]);
            } else {
                flash()->error('Error!', 'There was an issue removing this user. Please try again.');

                return redirect()->route('admin.roles.show', [$roleId]);
            }
        } catch (CannotRemoveRolesException $e) {
            flash()->setTimer(null)->error('Error!', $e->getMessage());

            return redirect()->route('admin.roles.show', [$roleId]);
        }
    }
}
