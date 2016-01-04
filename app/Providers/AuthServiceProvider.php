<?php

namespace App\Providers;

use App\Policies\GlobalPolicy;
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

        // Register global policies.
        foreach (get_class_methods(GlobalPolicy::class) as $method) {
            $callback = sprintf('%s@%s', GlobalPolicy::class, $method);

            $gate->define($method, $callback);
        }
    }
}
