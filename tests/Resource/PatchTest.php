<?php

namespace App\Tests\Resource;

use App\Tests\TestCase;

class PatchTest extends TestCase
{
    public function test_regular_users_do_not_have_access()
    {
        $this->actingAs($this->createUser());

        $this->get(route('resources.patches.index'))
            ->see('403');

        $this->post(route('resources.patches.store'))
            ->see('403');

        $this->post(route('resources.patches.show', [1]))
            ->see('403');

        $this->post(route('resources.patches.destroy', [1]))
            ->see('403');
    }

    public function test_create_patch()
    {
        $this->actingAs($this->createAdmin());

        $patch = [
            'title'         => 'Patch title',
            'description'   => 'Patch description',
        ];

        $this->post(route('resources.patches.store'), $patch);

        $this->seeInDatabase('patches', $patch);
    }

    public function test_edit_patch()
    {
        $this->test_create_patch();

        $patch = [
            'title'         => 'New title',
            'description'   => 'Patch description',
        ];

        $this->patch(route('resources.patches.update', [1]), $patch);

        $this->seeInDatabase('patches', $patch);
    }

    public function test_destroy_patch()
    {
        $this->test_create_patch();

        $this->delete(route('resources.patches.destroy', [1]));

        $this->dontSeeInDatabase('patches', ['id' => 1]);
    }
}
