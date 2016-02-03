<?php

namespace App\Jobs\Service;

use App\Http\Requests\Service\ServiceRequest;
use App\Jobs\Job;
use App\Models\Service;

class Update extends Job
{
    /**
     * @var ServiceRequest
     */
    protected $request;

    /**
     * @var Service
     */
    protected $service;

    /**
     * Constructor.
     *
     * @param ServiceRequest $request
     * @param Service        $service
     */
    public function __construct(ServiceRequest $request, Service $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->service->name = $this->request->input('name', $this->service->name);
        $this->service->description = $this->request->input('description', $this->service->description);

        return $this->service->save();
    }
}
