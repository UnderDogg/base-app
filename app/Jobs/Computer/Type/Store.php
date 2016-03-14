<?php

namespace App\Jobs\Computer\Type;

use App\Http\Requests\Device\ComputerTypeRequest;
use App\Jobs\Job;
use App\Models\ComputerType;

class Store extends Job
{
    /**
     * @var ComputerTypeRequest
     */
    protected $request;

    /**
     * @var ComputerType
     */
    protected $type;

    /**
     * Constructor.
     *
     * @param ComputerTypeRequest $request
     * @param ComputerType        $type
     */
    public function __construct(ComputerTypeRequest $request, ComputerType $type)
    {
        $this->request = $request;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->type->name = $this->request->input('name');

        return $this->type->save();
    }
}
