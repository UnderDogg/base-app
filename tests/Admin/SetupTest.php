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

    public function test_begin_setup_from_welcome()
    {
        $this->visit(route('admin.setup.welcome'))
            ->click('Begin')
            ->seePageIs(route('admin.setup.begin'));
    }

    public function test_begin_setup()
    {
        $this->visit(route('admin.setup.begin'))
            ->type('Admin', 'name')
            ->type('test@email.com', 'email')
            ->type('Password123', 'password')
            ->type('Password123', 'password_confirmation')
            ->submitForm('Complete Setup')
            ->assertResponseOk();
    }

    public function test_begin_setup_validation()
    {
        $this->call('POST', route('admin.setup.finish'));

        $session = session()->all();

        $name = $session['errors']->get('name');
        $email = $session['errors']->get('email');
        $password = $session['errors']->get('password');
        $passwordConfirmation = $session['errors']->get('password_confirmation');

        $this->assertCount(1, $name);
        $this->assertCount(1, $email);
        $this->assertCount(1, $password);
        $this->assertCount(1, $passwordConfirmation);
    }
}
