<?php

namespace App\Tests;

use App\Models\PasswordFolder;
use App\Models\User;

class PasswordFolderTest extends TestCase
{
    public function testRedirectedToSetupUponVisit()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->call('GET', route('passwords.index'));

        $this->assertRedirectedToRoute('passwords.setup');
    }

    public function testSetup()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->visit(route('passwords.setup'))
            ->type('password', 'pin')
            ->type('password', 'pin_confirmation')
            ->press('Setup');

        $record = PasswordFolder::where('user_id', $user->id)->first();

        $this->assertEquals($record->user_id, $user->id);
        $this->assertEquals(1, $record->locked);
    }

    public function testAccessAfterSetup()
    {
        $this->testSetup();

        $this->visit(route('passwords.gate'))
            ->type('password', 'pin')
            ->press('Unlock')
            ->see('All Passwords');
    }
}
