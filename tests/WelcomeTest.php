<?php

namespace App\Tests;

class WelcomeTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_home_works()
    {
        $this->visit('/')
            ->see('Welcome');
    }
}
