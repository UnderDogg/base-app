<?php

namespace App\Jobs\Service\Record;

use App\Jobs\Job;
use App\Models\Service;

class CreateFirst extends Job
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * Constructor.
     *
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        $title = 'This service is running normally.';

        return $this->service->records()->create(compact('title'));
    }
}
