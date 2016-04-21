<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The authenticator implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Handle guest redirects.
        if ($this->auth->guest() === false) {
            // User is authenticated. Return request.
            return $next($request);
        }

        if ($request->ajax()) {
            // We've received an unauthenticated ajax response,
            // we'll let them know it's unauthorized.
            return response('Unauthorized.', 401);
        }

        // The user is a guest, we'll redirect them to the login page.
        return redirect()->guest(route('auth.login.index'));
    }
}
