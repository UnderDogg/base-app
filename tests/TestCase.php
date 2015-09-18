<?php

namespace App\Tests;

use Orchestra\Testing\ApplicationTestCase;

abstract class TestCase extends ApplicationTestCase
{
    /**
     * Base application namespace.
     *
     * @var string
     */
    protected $baseNamespace = 'App';

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Call the application migrations for testing.
     */
    public function setUp()
    {
        parent::setUp();

        // Call auth migrations
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../vendor/orchestra/auth/resources/database/migrations'),
        ]);

        // Call control extension activation
        $this->artisan('extension:activate', [
            'name' => 'control',
        ]);

        // Call application migrations
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../resources/database/migrations'),
        ]);

        // Set the HTML table configuration
        $this->app['config']->set('orchestra/html::table', [
            'empty' => 'There are no records to display.',
            'view' => 'components.table',
        ]);

        // Set the HTML table configuration
        $this->app['config']->set('orchestra/html::form', [
            'view' => 'components.form',
            'format' => '<span class="label label-danger">:message</span>',
            'templates' => [
                'input'    => ['class' => 'col-md-12 input-with-feedback'],
                'password' => ['class' => 'col-md-12 input-with-feedback'],
                'select'   => ['class' => 'col-md-12 input-with-feedback'],
                'textarea' => ['class' => 'col-md-12 input-with-feedback'],
            ],
            'submit' => 'orchestra/foundation::label.submit',
            'presenter' => 'Orchestra\Html\Form\BootstrapThreePresenter',
        ]);
    }

    /**
     * Get base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        return realpath(__DIR__.'/../');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // $app['router']->disableFilters();
    }
}
