<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

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

        $gate->before(function ($user) {
            return ($user->hasRole(Role::getAdministratorName()) ?: null);
        });

        $this->defineCommentAbilities($gate);
        $this->defineIssueAbilities($gate);
        $this->defineInquiryAbilities($gate);
        $this->defineGuideAbilities($gate);
    }

    /**
     * Define comment abilities.
     *
     * @param Gate $gate
     */
    protected function defineCommentAbilities(Gate $gate)
    {
        // Edit comments.
        $gate->define('comments.edit', function ($user, $comment) {
            return $user->id == $comment->user_id;
        });

        // Delete comments.
        $gate->define('comments.destroy', function ($user, $comment) {
            return $user->id == $comment->user_id;
        });
    }

    /**
     * Defines issue abilities.
     *
     * @param Gate $gate
     */
    protected function defineIssueAbilities(Gate $gate)
    {
        // View issues.
        $gate->define('issues.show', function ($user, $issue) {
            return $user->can('manage.issues') ?: $user->id == $issue->user_id;
        });

        // Edit issues.
        $gate->define('issues.edit', function ($user, $issue) {
            return $user->can('manage.issues') ?: $user->id == $issue->user_id;
        });

        // Delete issues.
        $gate->define('issues.destroy', function ($user, $issue) {
            return $user->can('manage.issues') ?: $user->id == $issue->user_id;
        });

        // Close issues.
        $gate->define('issues.close', function ($user, $issue) {
            return $user->can('manage.issues') ?: $user->id == $issue->user_id;
        });

        // Re-open issues.
        $gate->define('issues.open', function ($user, $issue) {
            return $user->can('manage.issues');
        });
    }

    /**
     * Defines inquiry abilities.
     *
     * @param Gate $gate
     */
    protected function defineInquiryAbilities(Gate $gate)
    {
        // View inquiries.
        $gate->define('inquiries.show', function ($user, $inquiry) {
            return $user->can('manage.inquiries') ?: $user->id == $inquiry->user_id;
        });

        // Edit inquiries.
        $gate->define('inquiries.edit', function ($user, $inquiry) {
            return $user->can('manage.inquiries') ?: $user->id == $inquiry->user_id;
        });

        // Delete inquiries.
        $gate->define('inquiries.destroy', function ($user, $inquiry) {
            return $user->can('manage.inquiries') ?: $user->id == $inquiry->user_id;
        });

        // Approve inquiries.
        $gate->define('inquiries.approve', function ($user, $inquiry) {
            return $user->can('manage.inquiries');
        });

        // Re-open inquiries.
        $gate->define('inquiries.open', function ($user, $inquiry) {
            return $user->can('manage.inquiries');
        });

        // Close inquiries.
        $gate->define('inquiries.close', function ($user, $inquiry) {
            return $user->can('manage.inquiries') ?: $user->id == $inquiry->user_id;
        });
    }

    protected function defineGuideAbilities(Gate $gate)
    {
        // View guides.
        $gate->define('guides.show', function ($user, $guide) {
            return $user->can('manage.guides') ?: $guide->published;
        });

        // Edit guides.
        $gate->define('guides.edit', function ($user, $guide) {
            return $user->can('manage.guides') ?: $user->id == $guide->user_id;
        });

        // Delete guides.
        $gate->define('guides.destroy', function ($user, $guide) {
            return $user->can('manage.guides') ?: $user->id == $guide->user_id;
        });
    }
}
