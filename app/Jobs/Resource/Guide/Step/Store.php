<?php

namespace App\Jobs\Resource\Guide\Step;

use App\Http\Requests\Resource\GuideStepRequest;
use App\Jobs\Job;
use App\Models\Guide;
use App\Models\GuideStep;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Store extends Job
{
    /**
     * @var GuideStepRequest
     */
    protected $request;

    /**
     * @var Guide
     */
    protected $guide;

    /**
     * Constructor.
     *
     * @param GuideStepRequest $request
     * @param Guide            $guide
     */
    public function __construct(GuideStepRequest $request, Guide $guide)
    {
        $this->request = $request;
        $this->guide = $guide;
    }

    /**
     * Execute the job.
     *
     * @return GuideStep|false
     */
    public function handle()
    {
        $title = $this->request->input('title');
        $description = $this->request->input('description');

        $step = $this->guide->addStep($title, $description);

        // Make sure we've created a step successfully.
        if ($step instanceof GuideStep) {
            // Retrieve the image for the step.
            $file = $this->request->file('image');

            if ($file instanceof UploadedFile) {
                // Looks like an image was uploaded, we'll move
                // it into storage and add it to the step.
                $step->uploadFile($file, $path = null, $resize = true);
            }

            // No image was uploaded, we'll return the step.
            return $step;
        }

        return false;
    }
}
