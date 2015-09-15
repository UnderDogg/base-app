<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * The username string to use for authentication.
     *
     * @var string
     */
    protected $username = 'mail';

    /**
     * Constructor.
     *
     * Sets the auth driver to adldap.
     */
    public function __construct()
    {
        Config::set('auth.driver', 'adldap');
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login.index');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool                      $throttles
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        flash()->success('Success!', "You're logged in!");

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        flash()->success('Success!', "You've been logged out!");

        return redirect('/');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
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

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }
}
