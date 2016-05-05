<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Guide::class        => \App\Policies\Resource\GuidePolicy::class,
        \App\Models\GuideStep::class    => \App\Policies\Resource\GuideStepPolicy::class,
        \App\Models\Service::class      => \App\Policies\ServicePolicy::class,
        \App\Models\Issue::class        => \App\Policies\IssuePolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param Gate $gate
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        parent::registerPolicies($gate);
    }
}
