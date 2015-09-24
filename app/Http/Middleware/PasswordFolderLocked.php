<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PasswordFolder;
use Illuminate\Http\Request;

class PasswordFolderLocked
{
    /**
     * @var PasswordFolder
     */
    protected $folder;

    /**
     * Constructor.
     *
     * @param PasswordFolder $folder
     */
    public function __construct(PasswordFolder $folder)
    {
        $this->folder = $folder;
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
        $folder = auth()->user()->load('passwordFolder')->passwordFolder;

        if($folder && $folder->locked && ! $request->session()->has($folder->uuid)) {
            // If the folder is locked and we can't see the folder
            // UUID in the users session, we'll redirect
            // them to the password gate.
            return redirect()->route('passwords.gate');
        } else if (!$folder) {
            // If no folder exists for the user, we need
            // to redirect them to the setup page.
            return redirect()->route('passwords.setup');
        }

        return $next($request);
    }
}
