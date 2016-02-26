<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @param Gate $gate
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->policies = config('authorization.policies');

        parent::registerPolicies($gate);
    }
}
