<?php

namespace App\Tests;

use App\Models\User;

class WelcomeTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_home_works()
    {
        $this->visit('/')->assertResponseOk();
    }

    public function test_home_logged_in()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->visit('/')
            ->see('Last Ticket');
    }
}
