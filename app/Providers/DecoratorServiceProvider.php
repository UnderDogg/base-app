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
        Decorator::macro('navbar', function (Fluent $navbar) {
            return view('components.navbar', compact('navbar'));
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
