<?php

namespace App\Jobs\Computer\Patch;

use App\Http\Requests\Device\ComputerPatchRequest;
use App\Jobs\Job;
use App\Models\Computer;

class Store extends Job
{
    /**
     * @var ComputerPatchRequest
     */
    protected $request;

    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param ComputerPatchRequest $request
     * @param Computer             $computer
     */
    public function __construct(ComputerPatchRequest $request, Computer $computer)
    {
        $this->request = $request;
        $this->computer = $computer;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        return $this->computer->patches()->create([
            'title'       => $this->request->input('title'),
            'description' => $this->request->input('description'),
        ]);
    }
}
