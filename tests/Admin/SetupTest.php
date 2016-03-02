<?php

namespace App\Tests\Admin;

use App\Models\User;
use App\Tests\TestCase;

class SetupTest extends TestCase
{
    public function test_can_setup()
    {
        $this->visit(route('admin.setup.welcome'))->assertResponseOk();
    }

    public function test_cannot_setup()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->call('GET', route('admin.setup.welcome'));

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function test_begin_setup()
    {
        $this->visit(route('admin.setup.welcome'))
            ->click('Begin')
            ->seePageIs(route('admin.setup.begin'));
    }
}
