<?php

class GuideTest extends TestCase
{
    public function test_guest_have_access()
    {
        $this->visit(route('resources.guides.index'))
            ->assertResponseOk();
    }

    public function test_guests_do_not_have_access()
    {
        $create = $this->call('GET', route('resources.guides.create'));
        $store = $this->call('POST', route('resources.guides.store'));

        $this->assertEquals(403, $create->getStatusCode());
        $this->assertEquals(403, $store->getStatusCode());
    }

    public function test_regular_user_does_not_has_access()
    {
        $user = factory(\App\Models\User::class)->create();

        $this->actingAs($user)->call('GET', route('resources.guides.create'))->setStatusCode(403);

        $create = $this->call('GET', route('resources.guides.create'));
        $store = $this->call('POST', route('resources.guides.store'));

        $this->assertEquals(403, $create->getStatusCode());
        $this->assertEquals(403, $store->getStatusCode());
    }
}
