<?php

namespace App\Http\Middleware\ActiveDirectory\Questions;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AlreadySetupMiddleware
{
    /**
     * Prevents users from visiting the question setup
     * if they have at least 3 questions setup.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user instanceof User && count($user->questions) < 3) {
            return $next($request);
        }

        return redirect()->route('security-questions.index');
    }
}
