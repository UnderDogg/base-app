<?php

namespace App\Jobs\Resource\Guide\Step;

use App\Http\Requests\Resource\GuideStepMoveRequest;
use App\Jobs\Job;
use App\Models\GuideStep;

class Move extends Job
{
    /**
     * @var GuideStepMoveRequest
     */
    protected $request;

    /**
     * @var GuideStep
     */
    protected $step;

    /**
     * Constructor.
     *
     * @param GuideStepMoveRequest $request
     * @param GuideStep            $step
     */
    public function __construct(GuideStepMoveRequest $request, GuideStep $step)
    {
        $this->request = $request;
        $this->step = $step;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->step instanceof GuideStep) {
            $position = (int) $this->request->input('position', 1);

            return $this->step->insertAt($position);
        }

        return false;
    }
}
