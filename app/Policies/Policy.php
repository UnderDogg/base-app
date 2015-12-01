<?php

namespace App\Policies;

use App\Models\User;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\Foundation;
use Orchestra\Authorization\Policy as AuthorizationPolicy;

abstract class Policy extends AuthorizationPolicy
{
    /**
     * The policy actions.
     *
     * @var array
     */
    public $actions = [];

    /**
     * The authorization name.
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = Foundation::memory()->get('site.name');
    }

    /**
     * Intercepts all checks and allows administrators
     * to perform all tasks.
     *
     * @param User $user
     *
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->is($this->admin()->name)) {
            return true;
        }
    }

    /**
     * Returns the administrators role.
     *
     * @return null|Role
     */
    public function admin()
    {
        return Role::admin();
    }
}
