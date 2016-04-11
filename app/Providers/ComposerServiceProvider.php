<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * The view composers to register.
     *
     * @var array
     */
    protected $composers = [
        'layouts._nav' => \App\Http\Composers\Layout\NavigationComposer::class,
        'pages.issues._nav' => \App\Http\Composers\Issue\NavigationComposer::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->composers as $view => $composer) {
            View::composer($view, $composer);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
