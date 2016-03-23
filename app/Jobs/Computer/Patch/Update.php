<?php

namespace App\Jobs\Computer\Patch;

use App\Http\Requests\Device\ComputerPatchRequest;
use App\Jobs\Job;
use App\Models\ComputerPatch;

class Update extends Job
{
    /**
     * @var ComputerPatchRequest
     */
    protected $request;

    /**
     * @var ComputerPatch
     */
    protected $patch;

    /**
     * Constructor.
     *
     * @param ComputerPatchRequest $request
     * @param ComputerPatch        $patch
     */
    public function __construct(ComputerPatchRequest $request, ComputerPatch $patch)
    {
        $this->request = $request;
        $this->patch = $patch;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->patch->title = $this->request->input('title', $this->patch->title);
        $this->patch->description = $this->request->input('description', $this->patch->description);

        return $this->patch->save();
    }
}
