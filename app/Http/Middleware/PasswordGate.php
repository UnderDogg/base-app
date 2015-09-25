<?php

namespace App\Http\Middleware;

use App\Models\PasswordFolder;
use Closure;
use Illuminate\Http\Request;

class PasswordGate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $folder = auth()->user()->passwordFolder;

        if ($folder instanceof PasswordFolder) {
            // If a password folder exists, we can allow
            // them to access the gate to unlock it.
            return $next($request);
        }

        // Otherwise we'll redirect them to
        // the password folder setup.
        return redirect()->route('passwords.setup');
    }
}
