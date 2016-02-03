<?php

namespace App\Jobs\Service\Record;

use App\Http\Requests\Service\ServiceRecordRequest;
use App\Jobs\Job;
use App\Models\Service;

class Store extends Job
{
    /**
     * @var ServiceRecordRequest
     */
    protected $request;

    /**
     * @var Service
     */
    protected $service;

    /**
     * Constructor.
     *
     * @param ServiceRecordRequest $request
     * @param Service              $service
     */
    public function __construct(ServiceRecordRequest $request, Service $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        $status = $this->request->input('status');
        $title = $this->request->input('title');
        $description = $this->request->input('description');

        return $this->service->records()->create(compact('status', 'title', 'description'));
    }
}
