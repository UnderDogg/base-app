<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

class SetupMiddleware
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Role $role
     * @param User $user
     */
    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
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
        // Retrieve the administrator role.
        $administrator = $this->role->whereName(Role::getAdministratorName())->first();

        // Retrieve the count of users.
        $users = $this->user->count();

        if ($administrator instanceof Role && !$request->user() && $users === 0) {
            // If the administrator role has been created, no user
            // is logged in, and no users exist,
            // we'll allow the setup request.
            return $next($request);
        }

        // If the administrator role hasn't already been created,
        // we'll throw an Unauthorized Exception.
        throw new HttpException(403, 'Unauthorized.');
    }
}
