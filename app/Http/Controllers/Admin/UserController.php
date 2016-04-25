<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Admin\CannotRemoveRolesException;
use App\Http\Controllers\Controller;
use App\Http\Presenters\Admin\UserPresenter;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\Admin\User\Store;
use App\Jobs\Admin\User\Update;
use App\Models\User;
use App\Processors\Admin\UserProcessor;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserPresenter
     */
    protected $presenter;

    /**
     *  Constructor.
     *
     * @param User          $user
     * @param UserPresenter $presenter
     */
    public function __construct(User $user, UserPresenter $presenter)
    {
        $this->user = $user;
        $this->presenter = $presenter;
    }

    /**
     * Displays all users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('admin.users.index');

        $users = $this->presenter->table($this->user);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Displays the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('admin.users.create');

        $form = $this->presenter->form($this->user);

        return view('admin.users.create', compact('form'));
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
        $this->authorize('admin.users.create');

        $user = $this->user->newInstance();

        if ($this->dispatch(new Store($request, $user))) {
            flash()->success('Success!', 'Successfully created user.');

            return redirect()->route('admin.users.index');
        }

        flash()->error('Error!', 'There was an issue creating a user. Please try again.');

        return redirect()->route('admin.users.create');
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
        $this->authorize('admin.users.show');

        $user = $this->user->with(['roles'])->findOrFail($id);

        $permissions = $this->presenter->tablePermissions($user);

        $formPermissions = $this->presenter->formPermissions($user);

        return view('admin.users.show', compact('user', 'permissions', 'formPermissions'));
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
        $this->authorize('admin.users.edit');

        $user = $this->user->findOrFail($id);

        $form = $this->presenter->form($user);

        return view('admin.users.edit', compact('form'));
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
        $this->authorize('admin.users.edit');

        $user = $this->user->findOrFail($id);

        try {
            if ($this->dispatch(new Update($request, $user))) {
                flash()->success('Success!', 'Successfully updated user.');

                return redirect()->route('admin.users.show', [$id]);
            }

            flash()->error('Error!', 'There was an issue updating this user. Please try again.');

            return redirect()->route('admin.users.edit', [$id]);
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
        $this->authorize('admin.users.destroy');

        $user = $this->user->findOrFail($id);

        if ($user->delete()) {
            flash()->success('Success!', 'Successfully deleted user.');

            return redirect()->route('admin.users.index');
        }

        flash()->success('Success!', 'There was an issue deleting this user. Please try again.');

        return redirect()->route('admin.users.show', [$id]);
    }
}
