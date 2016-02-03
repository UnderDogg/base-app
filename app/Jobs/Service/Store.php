<?php

namespace App\Jobs\Service;

use App\Http\Requests\Service\ServiceRequest;
use App\Jobs\Job;
use App\Jobs\Service\Record\CreateFirst;
use App\Models\Service;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Store extends Job
{
    use DispatchesJobs;

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
        $this->service->name = $this->request->input('name');
        $this->service->description = $this->request->input('description');

        if ($this->service->save()) {
            $this->dispatch(new CreateFirst($this->service));

            return true;
        }

        return false;
    }
}
