<?php

namespace App\Jobs\Computer\System;

use App\Http\Requests\Computer\ComputerSystemRequest;
use App\Jobs\Job;
use App\Models\OperatingSystem;

class Store extends Job
{
    /**
     * @var ComputerSystemRequest
     */
    protected $request;

    /**
     * @var OperatingSystem
     */
    protected $system;

    /**
     * Constructor.
     *
     * @param ComputerSystemRequest $request
     * @param OperatingSystem       $system
     */
    public function __construct(ComputerSystemRequest $request, OperatingSystem $system)
    {
        $this->request = $request;
        $this->system = $system;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->system->name = $this->request->input('name');
        $this->system->version = $this->request->input('version');
        $this->system->service_pack = $this->request->input('service_pack');

        return $this->system->save();
    }
}
