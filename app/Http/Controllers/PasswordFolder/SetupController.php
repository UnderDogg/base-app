<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Controllers\Controller;
use App\Http\Presenters\PasswordFolder\SetupPresenter;
use App\Http\Requests\PasswordFolder\SetupRequest;
use App\Models\PasswordFolder;

class SetupController extends Controller
{
    /**
     * @var PasswordFolder
     */
    protected $folder;

    /**
     * @var SetupPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param PasswordFolder $folder
     * @param SetupPresenter $presenter
     */
    public function __construct(PasswordFolder $folder, SetupPresenter $presenter)
    {
        $this->folder = $folder;
        $this->presenter = $presenter;
    }

    /**
     * Displays the password setup form.
     *
     * @return \Illuminate\View\View
     */
    public function start()
    {
        $form = $this->presenter->form($this->folder);

        return view('pages.passwords.setup', compact('form'));
    }

    /**
     * Finishes the users password folder setup.
     *
     * @param SetupRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(SetupRequest $request)
    {
        if ($request->persist($this->folder)) {
            flash()->success('Success!', 'Successfully setup passwords.');

            return redirect()->route('passwords.gate');
        }

        flash()->success('Error!', 'There was an error setting up passwords. Please try again.');

        return redirect()->back();
    }

    /**
     * Displays the invalid setup page.
     *
     * @return \Illuminate\View\View
     */
    public function invalid()
    {
        return view('pages.passwords.invalid');
    }
}
