<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Model;
use Illuminate\Support\ServiceProvider;
use Orchestra\Support\Facades\Decorator;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the decorator macros.
     */
    public function boot()
    {
        Decorator::macro('comment', function (Comment $comment, array $actions) {
            return view('components.comment', compact('comment', 'actions'));
        });

        Decorator::macro('closed', function (Model $model) {
            return view('components.closed', compact('model'));
        });

        Decorator::macro('navbar', function ($navbar) {
            return view('components.navbar', compact('navbar'));
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
