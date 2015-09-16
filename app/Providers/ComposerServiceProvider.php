<?php

namespace App\Providers;

use App\Http\ViewComposers\Select\LabelSelectComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * The view composers array.
     *
     * @var array
     */
    protected $composers = [
        'components.select.labels' => LabelSelectComposer::class,
    ];

    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        foreach($this->composers as $view => $composer) {
            view()->composer($view, $composer);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
