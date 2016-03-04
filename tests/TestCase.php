<?php

namespace App\Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Set up the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->afterApplicationCreated(function () {
            dd($this->artisan('db:seed'));
        });
    }

    /**
     * Creates a normal user for testing.
     *
     * @return \App\Models\User
     */
    protected function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * Creates an administrator for testing.
     *
     * @return \App\Models\User
     */
    protected function createAdmin()
    {
        $user = factory(User::class)->create();

        $admin = $user->roles()
            ->getRelated()
            ->whereName(Role::getAdministratorName())
            ->firstOrFail();

        $user->assignRole($admin);

        return $user;
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);

        return $app;
    }
}
