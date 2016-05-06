<?php

namespace App\Tests\Admin;

use App\Tests\TestCase;

class SetupTest extends TestCase
{
    public function test_can_setup()
    {
        $this->visit(route('admin.setup.welcome'))
            ->assertResponseOk();
    }

    public function test_cannot_setup()
    {
        $this->actingAs($this->createUser());

        $this->get(route('admin.setup.welcome'))->see(403);
    }

    public function test_begin_setup_from_welcome()
    {
        $this->visit(route('admin.setup.welcome'))
            ->click('Begin')
            ->seePageIs(route('admin.setup.begin'));
    }

    public function test_begin_setup()
    {
        $this->call('POST', route('admin.setup.finish'), [
            'name'                  => 'Admin',
            'email'                 => 'test@email.com',
            'password'              => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $this->seeInDatabase('users', [
            'name'  => 'Admin',
            'email' => 'test@email.com',
        ]);
    }

    public function test_begin_setup_validation()
    {
        $this->post(route('admin.setup.finish'));

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
