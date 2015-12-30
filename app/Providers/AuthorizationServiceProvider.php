<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\ACL;

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

        try {
            $memory = $foundation->memory();

            $roles = Role::all()->pluck('name');

            $this->app->booted(function () use ($policies, $memory, $roles) {
                foreach ($policies as $policy) {
                    $acl = ACL::make($policy);

                    $acl->attach($memory);

                    $actions = [];

                    if (property_exists($policy, 'actions') && $policy = app($policy)) {
                        $actions = array_merge($actions, $policy->actions);
                    }

                    $acl->roles()->attach($roles);

                    $acl->actions()->attach($actions);

                    $admin = Role::admin();

                    if ($admin instanceof Role) {
                        $acl->allow($admin->name, $actions);
                    }
                }
            });
        } catch (\PDOException $e) {
            //
        } catch (\ReflectionException $e) {
            //
        }
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
