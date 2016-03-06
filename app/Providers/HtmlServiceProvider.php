<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchestra\Html\Form\Factory as FormFactory;
use Orchestra\Html\Table\Factory as TableFactory;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Bind the form factory.
        $this->app->bind('Orchestra\Contracts\Html\Form\Factory', function ($app) {
            $factory = new FormFactory($app);

            $factory->setConfig([
                'format' => '<span class="label label-danger">:message</span>',
                'view'   => 'admin.components.form',
            ]);

            return $factory;
        });

        // Bind the table factory.
        $this->app->bind('Orchestra\Contracts\Html\Table\Factory', function ($app) {
            $factory = new TableFactory($app);

            $factory->setConfig([
                'empty' => 'There are no records to display.',
                'view'  => 'admin.components.table',
            ]);

            return $factory;
        });
    }
}
