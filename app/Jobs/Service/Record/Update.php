<?php

namespace App\Jobs\Service\Record;

use App\Http\Requests\Service\ServiceRecordRequest;
use App\Jobs\Job;
use App\Models\ServiceRecord;

class Update extends Job
{
    /**
     * @var ServiceRecordRequest
     */
    protected $request;

    /**
     * @var ServiceRecord
     */
    protected $record;

    /**
     * Constructor.
     *
     * @param ServiceRecordRequest $request
     * @param ServiceRecord        $record
     */
    public function __construct(ServiceRecordRequest $request, ServiceRecord $record)
    {
        $this->request = $request;
        $this->record = $record;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->record->status = $this->record->input('status', $this->record->status);
        $this->record->title = $this->request->input('title', $this->record->title);
        $this->record->description = $this->request->input('description', $this->record->description);

        return $this->record->save();
    }
}
