<?php

namespace App\Providers;

use Orchestra\Support\Facades\Decorator;
use Illuminate\Support\ServiceProvider;

class DecoratorServiceProvider extends ServiceProvider
{
    /**
     * Register the decorator macros.
     */
    public function boot()
    {
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
