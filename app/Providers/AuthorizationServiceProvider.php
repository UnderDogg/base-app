<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Orchestra\Contracts\Foundation\Foundation;
use Orchestra\Memory\MemoryManager;
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
    public function boot()
    {
        $policies = config('authorization.policies');

        $roles = Role::all()->pluck('name');

        $this->app->booted(function (Application $app) use ($policies, $roles) {
            $foundation = $app->make(Foundation::class);

            $manager = $app->make(MemoryManager::class);

            if ($foundation instanceof Foundation && $manager instanceof MemoryManager) {
                $memory = $manager->makeOrFallback($manager->getDefaultDriver());

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
