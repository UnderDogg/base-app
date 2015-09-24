<?php

namespace App\Processors;

use App\Http\Requests\PasswordFolder\PasswordRequest;
use App\Http\Presenters\PasswordFolder\PasswordPresenter;
use App\Models\Password;
use App\Models\PasswordFolder;

class PasswordProcessor extends Processor
{
    /**
     * @var PasswordFolder
     */
    protected $folder;

    /**
     * @var Password
     */
    protected $password;

    /**
     * @var PasswordPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Password $password
     * @param PasswordPresenter $presenter
     */
    public function __construct(Password $password, PasswordPresenter $presenter)
    {
        $this->folder = auth()->user()->passwordFolder;
        $this->password = $password;
        $this->presenter = $presenter;
    }

    /**
     * Displays all of the users passwords.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $passwords = $this->presenter->table($this->password);

        $navbar = $this->presenter->navbar();

        return view('pages.passwords.index', compact('passwords', 'navbar'));
    }

    /**
     * Displays the form to create a password.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->password);

        return view('pages.passwords.create', compact('form'));
    }

    /**
     * Creates a new user password.
     *
     * @param PasswordRequest $request
     *
     * @return Password|bool
     */
    public function store(PasswordRequest $request)
    {
        $this->password->folder_id = $this->folder->getKey();
        $this->password->title = $request->input('title');
        $this->password->website = $request->input('website');
        $this->password->username = $request->input('username');
        $this->password->password = $request->input('password');
        $this->password->notes = $request->input('notes');

        if ($this->password->save()) {
            return $this->password;
        }

        return false;
    }

    /**
     * Displays the users specified password.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $password = $this->folder->passwords()->findOrFail($id);

        $form = $this->presenter->form($password, $viewing = true);

        return view('pages.passwords.show', compact('password', 'form'));
    }

    /**
     * Displays the edit form for the specified user password.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $password = $this->folder->passwords()->findOrFail($id);

        $form = $this->presenter->form($password);

        return view('pages.passwords.edit', compact('password', 'form'));
    }

    /**
     * Updates the users specified password.
     *
     * @param PasswordRequest $request
     * @param int|string      $id
     *
     * @return bool
     */
    public function update(PasswordRequest $request, $id)
    {
        $password = $this->folder->passwords()->findOrFail($id);

        $password->title    = $request->input('title', $password->title);
        $password->website  = $request->input('website', $password->website);
        $password->username = $request->input('username', $password->username);
        $password->password = $request->input('password', $password->password);
        $password->notes    = $request->input('notes', $password->notes);

        if ($password->save()) {
            return $password;
        }

        return false;
    }

    /**
     * Deletes the specified user password record.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $password = $this->folder->passwords()->findOrFail($id);

        return $password->delete();
    }
}
