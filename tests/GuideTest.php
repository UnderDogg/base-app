<?php

namespace App\Tests;

use App\Models\Guide;

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

        $this->actingAs($user);

        $create = $this->call('GET', route('resources.guides.create'));
        $this->assertEquals(403, $create->getStatusCode());

        $store = $this->call('POST', route('resources.guides.store'));
        $this->assertEquals(403, $store->getStatusCode());
    }

    public function test_guide_store()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $response = $this->call('POST', route('resources.guides.store'), [
            'title' => 'Title',
            'slug' => 'guide-slug',
            'description' => 'Description',
        ]);

        $session = session()->all();

        $this->assertEquals($session['flash_message']['title'], 'Success!');
        $this->assertEquals(302, $response->getStatusCode());
        $this->seeInDatabase('guides', ['title' => 'Title']);
    }

    public function test_guide_update()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $guide = factory(Guide::class)->create();

        $response = $this->call('PUT', route('resources.guides.update', $guide->slug), [
            'title' => 'New Title',
            'slug' => 'new-slug',
            'description' => 'Description',
        ]);

        $session = session()->all();

        $this->assertEquals($session['flash_message']['title'], 'Success!');
        $this->assertEquals(302, $response->getStatusCode());
        $this->seeInDatabase('guides', ['title' => 'New Title']);
    }

    public function test_guide_unique_title_validation()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $response = $this->call('POST', route('resources.guides.store'), [
            'title' => $guide->title,
            'slug' => 'guide-slug',
            'description' => 'Description',
        ]);

        $session = session()->all();

        $this->assertCount(1, $session['errors']->get('title'));
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_guide_unique_slug_validation()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $response = $this->call('POST', route('resources.guides.store'), [
            'title' => 'New Title',
            'slug' => $guide->slug,
            'description' => 'Description',
        ]);

        $session = session()->all();

        $this->assertCount(1, $session['errors']->get('slug'));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
