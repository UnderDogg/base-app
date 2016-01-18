<?php

namespace App\Jobs\Computer;

use App\Jobs\Job;
use App\Models\ComputerProcessor;
use App\Models\ComputerProcessorRecord;

class CreateProcessorRecord extends Job
{
    /**
     * @var ComputerProcessor
     */
    protected $processor;

    /**
     * The processor load.
     *
     * @var int
     */
    protected $load = 0;

    /**
     * The processor status.
     *
     * @var null
     */
    protected $status = null;

    /**
     * Constructor.
     *
     * @param ComputerProcessor $processor
     * @param int               $load
     * @param null              $status
     */
    public function __construct(ComputerProcessor $processor, $load = 0, $status = null)
    {
        $this->processor = $processor;
        $this->load = $load;
        $this->status = $status;
    }

    /**
     * Creates a new processor record.
     *
     * @return bool
     */
    public function handle()
    {
        $record = new ComputerProcessorRecord();

        $record->processor_id = $this->processor->getKey();
        $record->load = $this->load;
        $record->status = $this->status;

        return $record->save();
    }
}
