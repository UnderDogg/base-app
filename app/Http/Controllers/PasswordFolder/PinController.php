<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Controllers\Controller;
use App\Http\Presenters\PasswordFolder\PinPresenter;
use App\Http\Requests\PasswordFolder\ChangePinRequest;
use App\Models\PasswordFolder;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PinController extends Controller
{
    /**
     * @var PinPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param PinPresenter $presenter
     */
    public function __construct(PinPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Displays the form for changing the users
     * PIN for their password folder.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            $form = $this->presenter->form();

            return view('pages.passwords.pin.change', compact('form'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Updates the current users password folder PIN.
     *
     * @param ChangePinRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePinRequest $request)
    {
        $folder = Auth::user()->passwordFolder;

        if ($folder instanceof PasswordFolder && $folder->changePin($request)) {
            flash()->success('Success!', 'Successfully updated PIN.');

            return redirect()->route('passwords.index');
        }

        flash()->error('Error!', 'There was an issue changing your PIN. Your currect PIN may have been incorrect. Please try again.');

        return redirect()->back();
    }
}
