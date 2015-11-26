<?php

namespace App\Providers;

use App\Models\Guide;
use App\Models\GuideStep;
use App\Models\Observers\GuideObserver;
use App\Models\Observers\GuideStepObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * The model observers.
     *
     * @var array
     */
    protected $observers = [
        Guide::class => GuideObserver::class,
        GuideStep::class => GuideStepObserver::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->observers as $model => $observer) {
            $model::observe(new $observer);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
