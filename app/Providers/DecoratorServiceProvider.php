<?php

namespace App\Providers;

use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;
use Orchestra\Support\Facades\Decorator;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the decorator macros.
     */
    public function boot()
    {
        Decorator::macro('issue-comment', function (array $args) {
            $fluent = new Fluent($args);

            $comment = $fluent->comment;
            $actions = $fluent->actions;

            return view('components.comment', compact('comment', 'actions'));
        });

        Decorator::macro('navbar.pills', function ($navbar) {
            return view('components.navbar-pills', compact('navbar'));
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
