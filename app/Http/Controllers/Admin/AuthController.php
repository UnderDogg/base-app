<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Admin\AuthPresenter;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * @var AuthPresenter
     */
    protected $presenter;

    /**
     * Create a new authentication controller instance.
     *
     * @param AuthPresenter $presenter
     */
    public function __construct(AuthPresenter $presenter)
    {
        $this->presenter = $presenter;

        // Set the redirect to route after users login.
        $this->redirectTo = route('admin.welcome.index');

        // Set the redirect after logout route after users logout.
        $this->redirectAfterLogout = route('admin.auth.login');
    }

    /**
     * {@inheritdoc}
     */
    public function showLoginForm()
    {
        $form = $this->presenter->form();

        return view('admin.auth.login', compact('form'));
    }
}
