<?php

namespace App\Processors\Admin;

use App\Http\Presenters\Admin\UserPresenter;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\Admin\User\Store;
use App\Jobs\Admin\User\Update;
use App\Models\User;
use App\Processors\Processor;

class UserProcessor extends Processor
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
     * @return bool
     */
    public function store(UserRequest $request)
    {
        $this->authorize('admin.users.create');

        $user = $this->user->newInstance();

        return $this->dispatch(new Store($request, $user));
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
     * @return \Illuminate\View\View
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
     * @return bool
     */
    public function update(UserRequest $request, $id)
    {
        $this->authorize('admin.users.edit');

        $user = $this->user->findOrFail($id);

        return $this->dispatch(new Update($request, $user));
    }

    /**
     * Deletes the specified user.
     *
     * @return bool
     */
    public function destroy($id)
    {
        $this->authorize('admin.users.destroy');

        $user = $this->user->findOrFail($id);

        return $user->delete();
    }
}
