<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\Profile\InvalidPasswordException;
use App\Exceptions\Profile\UnableToChangePasswordException;
use App\Http\Controllers\Controller;
use App\Http\Presenters\Profile\PasswordPresenter;
use App\Http\Requests\Profile\PasswordRequest;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * @var PasswordPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param PasswordPresenter $presenter
     */
    public function __construct(PasswordPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Displays the form for changing the current users password.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        $form = $this->presenter->form();

        return view('pages.profile.show.password.change', compact('form'));
    }

    /**
     * Updates the current users password.
     *
     * @param PasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordRequest $request)
    {
        $flash = flash()->setTimer(3000);

        try {
            $request->persist(Auth::user());

            $flash->success('Success!', 'Successfully changed password.');

            return redirect()->route('profile.show');
        } catch (InvalidPasswordException $e) {
            $flash->error('Whoops!', 'Looks like your current password was incorrect. Try again.');

            return redirect()->route('profile.password');
        } catch (UnableToChangePasswordException $e) {
            $flash->error('Error!', 'Looks like we had an issue trying to change your password. Please try again.');

            return redirect()->route('profile.password');
        }
    }
}
