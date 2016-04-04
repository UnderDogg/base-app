<?php

namespace App\Jobs\Resource\Patch\Computer;

use App\Http\Requests\Resource\PatchComputerRequest;
use App\Jobs\Job;
use App\Models\Patch;
use Carbon\Carbon;

class Store extends Job
{
    /**
     * @var PatchComputerRequest
     */
    protected $request;

    /**
     * @var Patch
     */
    protected $patch;

    /**
     * Constructor.
     *
     * @param PatchComputerRequest $request
     * @param Patch                $patch
     */
    public function __construct(PatchComputerRequest $request, Patch $patch)
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
        $computers = $this->request->input('computers');

        if (is_array($computers)) {
            foreach ($computers as $computer) {
                // Make sure the computer isn't already attached.
                if (!$this->patch->computers()->find($computer)) {
                    // Attach the computer to the patch.
                    $this->patch->computers()->attach($computer, [
                        'patched_at' => new Carbon($this->request->input('patched')),
                    ]);
                }
            }

            return true;
        }

        return false;
    }
}
