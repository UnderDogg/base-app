<?php

namespace App\Providers;

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
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        //
    }
}
