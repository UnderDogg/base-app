<?php

namespace App\Processors\Device;

use App\Jobs\Computers\CreateStatus;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerStatusProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer $computer
     */
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    /**
     * Checks the specified computers online status.
     *
     * @param int|string $id
     *
     * @return bool|\App\Models\ComputerStatus
     */
    public function check($id)
    {
        $computer = $this->computer->findOrFail($id);

        return $this->dispatch(new CreateStatus($computer));
    }
}
