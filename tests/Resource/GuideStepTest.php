<?php

namespace App\Tests\Resource;

use App\Models\Guide;

class GuideStepTest extends GuideTest
{
    public function test_guide_step_store()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $response = $this->call('POST', route('resources.guides.steps.store', [$guide->slug]), [
            'title'       => 'New Step',
            'description' => 'Step Description',
        ]);

        $this->assertSessionHas('flash_message.level', 'success');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
