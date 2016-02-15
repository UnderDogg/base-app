<?php

namespace App\Jobs\Resource\Guide\Step;

use App\Http\Requests\Resource\GuideStepRequest;
use App\Jobs\Job;
use App\Models\Guide;
use App\Models\GuideStep;
use Illuminate\Http\UploadedFile;

class Update extends Job
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
     * @var GuideStep
     */
    protected $step;

    /**
     * Constructor.
     *
     * @param GuideStepRequest $request
     * @param Guide            $guide
     * @param GuideStep        $step
     */
    public function __construct(GuideStepRequest $request, Guide $guide, GuideStep $step)
    {
        $this->request = $request;
        $this->guide = $guide;
        $this->step = $step;
    }

    /**
     * Execute the job.
     *
     * @return GuideStep|bool
     */
    public function handle()
    {
        $this->step->title = $this->request->input('title', $this->step->title);
        $this->step->description = $this->request->input('description', $this->step->description);

        if ($this->step->save()) {
            // If saving the step is successful, we'll process the file upload if there is one.
            $file = $this->request->file('image');

            if ($file instanceof UploadedFile) {
                $this->step->deleteFiles();

                $this->step->uploadFile($file, $path = null, $resize = true);
            }

            return $this->step;
        }

        return false;
    }
}
