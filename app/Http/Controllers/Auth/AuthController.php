<?php

namespace App\Http\Controllers\Auth;

use Adldap\Models\User as AdldapUser;
use App\Http\Presenters\LoginPresenter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * @var LoginPresenter
     */
    protected $presenter;

    /**
     * The username string to use for authentication.
     *
     * @var string
     */
    protected $username = 'email';

    /**
     * Constructor.
     *
     * @param LoginPresenter $presenter
     */
    public function __construct(LoginPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        $form = $this->presenter->form();

        return view('pages.auth.login.index', compact('form'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        // Log the user out.
        Auth::logout();

        flash()->success('Success!', "You've been logged out!");

        return redirect('/');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, User $user)
    {
        if ($user->adldapUser instanceof AdldapUser) {
            $this->handleLdapUserWasAuthenticated($request->user(), $request->user()->adldapUser);
        }

        flash()->success('Success!', "You're logged in!");

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Attaches roles depending on the users active directory group.
     *
     * @param User       $user
     * @param AdldapUser $adldapUser
     */
    protected function handleLdapUserWasAuthenticated(User $user, AdldapUser $adldapUser)
    {
        if ($adldapUser->inGroup('Help Desk')) {
            $admin = Role::whereName(Role::getAdministratorName())->first();

            // If we have the administrator role and the user isn't
            // already a member, then we'll assign them the role.
            if ($admin instanceof Role && !$user->hasRole($admin)) {
                $user->assignRole($admin);
            }
        }
    }

    /**
     * Returns the failed login message.
     *
     * @return string
     */
    public function getFailedLoginMessage()
    {
        return 'The email or password was incorrect.';
    }

    /**
     * Returns the login path.
     *
     * @return string
     */
    public function loginPath()
    {
        return route('auth.login.index');
    }

    /**
     * Get the redirect path when users are authenticated.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('welcome.index');
    }
}
