<?php

namespace App\Tests\Resource;

use App\Models\Guide;
use App\Tests\TestCase;

class GuideTest extends TestCase
{
    public function test_guests_do_not_have_access()
    {
        $index = $this->call('GET', route('resources.guides.index'));
        $create = $this->call('GET', route('resources.guides.create'));
        $store = $this->call('POST', route('resources.guides.store'));

        $this->assertEquals(302, $index->getStatusCode());
        $this->assertEquals(302, $create->getStatusCode());
        $this->assertEquals(302, $store->getStatusCode());
    }

    public function test_regular_user_does_not_has_access()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->get(route('resources.guides.create'))
            ->see('403');

        $this->post(route('resources.guides.store'), [
            'title' => 'Guide Title',
            'slug'  => 'guide-slug',
        ])->see('403');
    }

    public function test_guide_store()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $this->post(route('resources.guides.store'), [
            'title'       => 'Title',
            'slug'        => 'guide-slug',
            'description' => 'Description',
        ]);

        $this->seeInDatabase('guides', [
            'id'    => 1,
            'title' => 'Title'
        ]);
    }

    public function test_guide_update()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $guide = factory(Guide::class)->create();

        $this->patch(route('resources.guides.update', $guide->slug), [
            'title'       => 'New Title',
            'slug'        => 'new-slug',
            'description' => 'Description',
        ]);

        $this->seeInDatabase('guides', [
            'id'    => 1,
            'title' => 'New Title'
        ]);
    }

    public function test_guide_unique_title_validation()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $this->post(route('resources.guides.store'), [
            'title'       => $guide->title,
            'slug'        => 'guide-slug',
            'description' => 'Description',
        ]);

        $this->assertSessionHasErrors(['title']);
    }

    public function test_guide_unique_slug_validation()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $response = $this->call('POST', route('resources.guides.store'), [
            'title'       => 'New Title',
            'slug'        => $guide->slug,
            'description' => 'Description',
        ]);

        $this->assertSessionHasErrors(['slug']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_delete_guide()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $this->delete(route('resources.guides.destroy', [$guide->slug]));

        $this->dontSeeInDatabase('guides', ['id' => 1]);
    }
}
