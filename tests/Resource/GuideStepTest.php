<?php

namespace App\Tests\Resource;

use App\Models\Guide;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function test_guide_step_create_and_add_another()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $this->visit(route('resources.guides.steps.create', [$guide->slug]))
            ->type('Step Title', 'title')
            ->type('Description', 'description')
            ->press('Create & Add Another')
            ->see('Success!')
            ->see('Create Step 2');
    }

    public function test_guide_step_store_with_attachment()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $this->visit(route('resources.guides.steps.create', [$guide->slug]))
            ->type('Step Title', 'title')
            ->type('Description', 'description')
            ->attach(base_path('tests/assets/test.jpg'), 'image')
            ->press('Create')
            ->see('Success!');
    }

    public function test_guide_step_store_with_invalid_attachment()
    {
        $this->test_guide_store();

        $guide = Guide::first();

        $this->visit(route('resources.guides.steps.create', [$guide->slug]))
            ->type('Step Title', 'title')
            ->type('Description', 'description')
            ->attach(base_path('tests/assets/blank.exe'), 'image')
            ->press('Create')
            ->see('The image must be an image.');
    }

    public function test_delete_image_from_guide()
    {
        $this->test_guide_step_store_with_attachment();

        $guide = Guide::first();

        $step = $guide->steps()->first();

        $response = $this->call('DELETE', route('resources.guides.steps.destroy', [$guide->slug, $step->getKey()]));

        $this->assertEquals(302, $response->getStatusCode());
    }
}
