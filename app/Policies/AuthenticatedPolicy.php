<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class AuthenticatedPolicy
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(403);
        }

        $this->user = $user;
    }
}
