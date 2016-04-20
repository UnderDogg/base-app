<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Controllers\Controller;
use App\Http\Presenters\PasswordFolder\PasswordPresenter;
use App\Http\Requests\PasswordFolder\PasswordRequest;
use App\Models\Password;
use App\Models\PasswordFolder;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
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
     * @param Password          $password
     * @param PasswordPresenter $presenter
     */
    public function __construct(Password $password, PasswordPresenter $presenter)
    {
        $this->password = $password;
        $this->presenter = $presenter;
    }

    /**
     * Displays the current users passwords.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $passwords = $this->presenter->table($folder->passwords()->getQuery());

            $navbar = $this->presenter->navbar();

            return view('pages.passwords.index', compact('passwords', 'navbar'));
        }

        throw new NotFoundHttpException();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PasswordRequest $request)
    {
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder && $request->persist($this->password, $folder)) {
            flash()->success('Success!', 'Successfully created password record.');

            return redirect()->route('passwords.index');
        }

        flash()->success('Error!', 'There was an issue creating a password record. Please try again.');

        return redirect()->back();
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
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $password = $folder->passwords()->findOrFail($id);

            $form = $this->presenter->form($password, $viewing = true);

            return view('pages.passwords.show', compact('password', 'form'));
        }

        throw new NotFoundHttpException();
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
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $password = $folder->passwords()->findOrFail($id);

            $form = $this->presenter->form($password);

            return view('pages.passwords.edit', compact('password', 'form'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Updates the users specified password record.
     *
     * @param PasswordRequest $request
     * @param int|string      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordRequest $request, $id)
    {
        $folder = Auth::user()->passwordFolder;

        $password = $folder->passwords()->findOrFail($id);

        if ($folder instanceof PasswordFolder && $request->persist($password, $folder)) {
            flash()->success('Success!', 'Successfully updated password record.');

            return redirect()->route('passwords.show', [$id]);
        }

        flash()->error('Error!', 'There was a problem updating this password record. Please try again.');

        return redirect()->route('passwords.edit', [$id]);
    }

    /**
     * Deletes the specified user password record.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $folder = Auth::user()->passwordFolder;

        $password = $folder->passwords()->findOrFail($id);

        if ($folder instanceof PasswordFolder && $password->delete()) {
            flash()->success('Success!', 'Successfully deleted password record.');

            return redirect()->route('passwords.index');
        }

        flash()->error('Error!', 'There was a problem deleting this password record. Please try again.');

        return redirect()->route('passwords.show', [$id]);
    }
}
