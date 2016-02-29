<?php

namespace App\Jobs\Resource\Guide\Step;

use App\Http\Requests\Resource\GuideStepImagesRequest;
use App\Jobs\Job;
use App\Models\Guide;
use App\Models\GuideStep;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload extends Job
{
    /**
     * @var GuideStepImagesRequest
     */
    protected $request;

    /**
     * @var Guide
     */
    protected $guide;

    /**
     * @var GuideStep
     */
    protected $step;

    /**
     * Constructor.
     *
     * @param GuideStepImagesRequest $request
     * @param Guide                  $guide
     * @param GuideStep              $step
     */
    public function __construct(GuideStepImagesRequest $request, Guide $guide, GuideStep $step)
    {
        $this->request = $request;
        $this->guide = $guide;
        $this->step = $step;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle()
    {
        $images = $this->request->file('images');

        $uploaded = 0;

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $step = $this->guide->addStep($image->getClientOriginalName());

                if ($step instanceof GuideStep) {
                    if ($step->uploadFile($image, $path = null, $resize = true)) {
                        $uploaded++;
                    }
                }
            }
        }

        return $uploaded;
    }
}
