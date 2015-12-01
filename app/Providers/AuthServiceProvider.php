<?php

namespace App\Providers;

use App\Policies\GlobalPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Issue::class            => \App\Policies\IssuePolicy::class,
        \App\Models\Comment::class          => \App\Policies\CommentPolicy::class,
        \App\Models\Label::class            => \App\Policies\LabelPolicy::class,
        \Adldap\Models\Computer::class      => \App\Policies\ActiveDirectory\ComputerPolicy::class,
        \Adldap\Models\User::class          => \App\Policies\ActiveDirectory\UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        // Register global policies.
        foreach (get_class_methods(GlobalPolicy::class) as $method) {
            $callback = sprintf('%s@%s', GlobalPolicy::class, $method);

            $gate->define($method, $callback);
        }
    }
}
