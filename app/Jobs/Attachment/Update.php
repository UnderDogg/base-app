<?php

namespace App\Jobs\Attachment;

use App\Http\Requests\AttachmentRequest;
use App\Jobs\Job;
use App\Models\Upload;

class Update extends Job
{
    /**
     * @var AttachmentRequest
     */
    protected $request;

    /**
     * @var Upload
     */
    protected $upload;

    /**
     * Constructor.
     *
     * @param AttachmentRequest $request
     * @param Upload            $upload
     */
    public function __construct(AttachmentRequest $request, Upload $upload)
    {
        $this->request = $request;
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->upload->name = $this->request->input('name', $this->upload->name);

        return $this->upload->save();
    }
}
