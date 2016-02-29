<?php

use App\Models\Password;
use App\Models\PasswordFolder;
use App\Models\User;

class PasswordFolderTest extends TestCase
{
    public function test_redirected_to_setup_upon_visit()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->call('GET', route('passwords.index'));

        $this->assertRedirectedToRoute('passwords.setup');
    }

    public function test_setup()
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

    public function test_access_after_setup()
    {
        $this->test_setup();

        $this->visit(route('passwords.gate'))
            ->type('password', 'pin')
            ->press('Unlock')
            ->see('All Passwords');
    }

    public function test_passwords_create()
    {
        $this->test_access_after_setup();

        $this->visit(route('passwords.create'))
            ->type('Title', 'title')
            ->type('Website', 'website')
            ->type('Username', 'username')
            ->type('Password123', 'password')
            ->type('Notes', 'notes')
            ->press('Create')
            ->assertResponseOk();
    }

    public function test_passwords_show()
    {
        $this->test_access_after_setup();

        $user = User::first();

        $folder = PasswordFolder::where('user_id', $user->id)->first();

        $password = factory(Password::class)->create([
            'folder_id' => $folder->getKey(),
        ]);

        $this->actingAs($password->folder->user);

        $this->visit(route('passwords.show', [$password->getKey()]))
            ->see($password->title)
            ->see('Edit')
            ->see('Delete');
    }

    public function test_passwords_edit()
    {
        $this->test_access_after_setup();

        $user = User::first();

        $folder = PasswordFolder::where('user_id', $user->id)->firstOrFail();

        $password = factory(Password::class)->create([
            'folder_id' => $folder->getKey(),
        ]);

        $this->actingAs($password->folder->user);

        $this->visit(route('passwords.edit', [$password->getKey()]))
            ->see($password->title)
            ->type(str_random(), 'password')
            ->press('Save')
            ->see('Success!')
            ->assertResponseOk();
    }

    public function test_passwords_delete()
    {
        $this->test_access_after_setup();

        $user = User::first();

        $folder = PasswordFolder::where('user_id', $user->id)->first();

        $password = factory(Password::class)->create([
            'folder_id' => $folder->getKey(),
        ]);

        $this->actingAs($password->folder->user);

        $token = [
            '_token' => \Session::token(),
        ];

        $this->delete(route('passwords.destroy', [$password->getKey()]), $token);

        $this->assertRedirectedToRoute('passwords.index');
    }
}
