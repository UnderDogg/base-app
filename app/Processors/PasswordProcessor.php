<?php

namespace App\Processors;

use App\Http\Requests\PasswordFolder\PasswordRequest;
use App\Http\Presenters\PasswordFolder\PasswordPresenter;
use App\Models\Password;
use App\Models\PasswordFolder;

class PasswordProcessor extends Processor
{
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
        $folder = auth()->user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $this->password->folder_id = $folder->getKey();
            $this->password->title = $request->input('title');
            $this->password->website = $request->input('website');
            $this->password->username = $request->input('username');
            $this->password->password = $request->input('password');
            $this->password->notes = $request->input('notes');

            if ($this->password->save()) {
                return $this->password;
            }
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
        $folder = auth()->user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $password = $folder->passwords()->findOrFail($id);

            return view('pages.passwords.show', compact('password'));
        }

        // Abort 404 as failsafe
        abort(404);
    }
}
