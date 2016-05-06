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
    }
}
