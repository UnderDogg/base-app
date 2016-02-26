<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Admin\CannotRemoveRolesException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Processors\Admin\UserProcessor;

class UserController extends Controller
{
    /**
     * @var UserProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param UserProcessor $processor
     */
    public function __construct(UserProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new user.
     *
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created user.');

            return redirect()->route('admin.users.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a user. Please try again.');

            return redirect()->route('admin.users.create');
        }
    }

    /**
     * Displays the specified user.
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
     * Displays the form for editing the specified user.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View|void
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified user.
     *
     * @param UserRequest $request
     * @param int|string  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        try {
            if ($this->processor->update($request, $id)) {
                flash()->success('Success!', 'Successfully updated user.');

                return redirect()->route('admin.users.show', [$id]);
            } else {
                flash()->error('Error!', 'There was an issue updating this user. Please try again.');

                return redirect()->route('admin.users.edit', [$id]);
            }
        } catch (CannotRemoveRolesException $e) {
            flash()->setTimer(null)->error('Error!', $e->getMessage());

            return redirect()->route('admin.users.edit', [$id]);
        }
    }

    /**
     * Deletes the specified user.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted user.');

            return redirect()->route('admin.users.index');
        } else {
            flash()->success('Success!', 'There was an issue deleting this user. Please try again.');

            return redirect()->route('admin.users.show', [$id]);
        }
    }
}
