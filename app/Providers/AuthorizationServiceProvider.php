<?php

namespace App\Providers;

use Orchestra\Model\Role;
use Orchestra\Support\Facades\ACL;
use Orchestra\Contracts\Foundation\Foundation;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Foundation $foundation
     *
     * @return void
     */
    public function boot(Foundation $foundation)
    {
        $policies = config('authorization.policies');

        $memory = $foundation->memory();

        $this->app->booted(function () use ($policies, $memory) {
            foreach ($policies as $policy) {
                $acl = ACL::make($policy);

                $acl->attach($memory);

                $actions = [];

                if (property_exists($policy, 'actions') && $policy = app($policy)) {
                    $actions = array_merge($actions, $policy->actions);
                }

                $roles = Role::lists('name')->all();

                $acl->roles()->attach($roles);

                $acl->actions()->attach($actions);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
