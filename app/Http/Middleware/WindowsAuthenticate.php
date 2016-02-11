<?php

namespace App\Http\Middleware;

use Closure;
use Adldap\Models\User as AdUser;
use Adldap\Contracts\Adldap;
use Adldap\Schemas\ActiveDirectory;
use App\Jobs\ActiveDirectory\ImportUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

class WindowsAuthenticate
{
    use DispatchesJobs;

    /**
     * The authenticator implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Create a new filter instance.
     *
     * @param Guard  $auth
     * @param Adldap $adldap
     */
    public function __construct(Guard $auth, Adldap $adldap)
    {
        $this->auth = $auth;
        $this->adldap = $adldap;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Handle Windows Authentication.
        if ($adUsername = $request->server('AUTH_USER')) {
            $user = User::where('ad_username', $adUsername)->first();

            if (!$user instanceof User) {
                // User is authenticated but does not have a web account.

                // Usernames will be prefixed with their domain, we just need their samAccountName.
                list($domain, $samAccountName) = explode('\\', $adUsername);

                $adUser = $this->adldap
                    ->search()
                    ->where(ActiveDirectory::ACCOUNT_NAME, '=', $samAccountName)
                    ->first();

                if ($adUser instanceof AdUser) {
                    $user = $this->dispatch(new ImportUser($adUser));
                }
            }

            if ($user instanceof User  && $this->auth->guest()) {
                // Double check user instance before logging them in.
                $this->auth->login($user);
            }
        }

        return $next($request);
    }
}
