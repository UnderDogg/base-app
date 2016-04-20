<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Controllers\Controller;
use App\Http\Presenters\PasswordFolder\GatePresenter;
use App\Http\Requests\PasswordFolder\LockRequest;
use App\Http\Requests\PasswordFolder\UnlockRequest;
use App\Models\PasswordFolder;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    /**
     * @var GatePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param GatePresenter $presenter
     */
    public function __construct(GatePresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Displays the password folder PIN gate.
     *
     * @return \Illuminate\View\View
     */
    public function gate()
    {
        $form = $this->presenter->form();

        return view('pages.passwords.gate', compact('form'));
    }

    /**
     * Unlocks a users password folder.
     *
     * @param UnlockRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function unlock(UnlockRequest $request)
    {
        $user = Auth::user();

        $folder = $user->passwordFolder;

        if ($folder instanceof PasswordFolder && $folder->unlock($request)) {
            flash()->success('Success!', 'Successfully entered password folder');

            return redirect()->route('passwords.index');
        }

        return redirect()->route('passwords.gate')->withErrors(['pin' => 'Incorrect PIN']);
    }

    /**
     * Locks the current users password folder.
     *
     * @param LockRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(LockRequest $request)
    {
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder && $folder->lock($request)) {
            flash()->success('Success!', 'Successfully locked passwords.');

            return redirect()->route('welcome.index');
        }

        flash()->error('Error!', 'There was a problem locking passwords. Please try again.');

        return redirect()->route('welcome.index');
    }
}
