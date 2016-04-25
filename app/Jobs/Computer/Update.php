<?php

namespace App\Jobs\Computer;

use App\Http\Requests\Computer\ComputerRequest;
use App\Jobs\Job;
use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\OperatingSystem;

class Update extends Job
{
    /**
     * @var ComputerRequest
     */
    protected $request;

    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param ComputerRequest $request
     * @param Computer        $computer
     */
    public function __construct(ComputerRequest $request, Computer $computer)
    {
        $this->request = $request;
        $this->computer = $computer;
    }

    /**
     * Execute the job.
     *
     * @return Computer|bool
     */
    public function handle()
    {
        $this->computer->os_id = OperatingSystem::findOrFail($this->request->input('os'))->id;
        $this->computer->type_id = ComputerType::findOrFail($this->request->input('type'))->id;
        $this->computer->name = $this->request->input('name');
        $this->computer->ip = $this->request->input('ip');
        $this->computer->model = $this->request->input('model');
        $this->computer->description = $this->request->input('description');

        if ($this->computer->save()) {
            return $this->computer;
        }

        return false;
    }
}
