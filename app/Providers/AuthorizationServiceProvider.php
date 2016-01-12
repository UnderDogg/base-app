<?php

namespace App\Providers;

use App\Policies\Policy;
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
     * @return void
     */
    public function boot()
    {
        $policies = config('authorization.policies', []);

        $roles = Role::all()->pluck('name')->toArray();

        $this->app->booted(function (Application $app) use ($policies, $roles) {
            $foundation = $app->make(Foundation::class);

            $manager = $app->make(MemoryManager::class);

            if ($foundation instanceof Foundation && $manager instanceof MemoryManager) {
                $this->registerPolicies($manager, $policies, $roles);
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

    /**
     * Registers the specified policies to the specified roles and attaches it to the memory manager.
     *
     * @param MemoryManager $manager
     * @param array         $policies
     * @param array         $roles
     */
    protected function registerPolicies(MemoryManager $manager, array $policies = [], array $roles = [])
    {
        $memory = $manager->makeOrFallback($manager->getDefaultDriver());

        foreach ($policies as $policy) {
            $policy = $this->app->make($policy);

            if ($policy instanceof Policy) {
                $acl = ACL::make($policy->getName());

                $acl->attach($memory);

                $actions = [];

                if (property_exists($policy, 'actions')) {
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
    }
}
