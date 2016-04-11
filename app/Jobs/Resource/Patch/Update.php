<?php

namespace App\Jobs\Resource\Patch;

use App\Http\Requests\Resource\PatchRequest;
use App\Jobs\Job;
use App\Models\Patch;

class Update extends Job
{
    /**
     * @var PatchRequest
     */
    protected $request;

    /**
     * @var Patch
     */
    protected $patch;

    /**
     * Constructor.
     *
     * @param PatchRequest $request
     * @param Patch        $patch
     */
    public function __construct(PatchRequest $request, Patch $patch)
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

        if ($this->patch->save()) {
            // Check if we have any files to upload and attach.
            if (count($this->request->files) > 0) {
                foreach ($this->request->file('files') as $file) {
                    if (!is_null($file)) {
                        $this->patch->uploadFile($file);
                    }
                }
            }

            return $this->patch;
        }

        return false;
    }
}
