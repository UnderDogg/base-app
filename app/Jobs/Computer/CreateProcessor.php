<?php

namespace App\Jobs\Computer;

use App\Jobs\Job;
use App\Models\Computer;
use App\Models\ComputerProcessor;

class CreateProcessor extends Job
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * The name of the processor.
     *
     * @var string
     */
    protected $name;

    /**
     * The family of the processor.
     *
     * @var null
     */
    protected $family;

    /**
     * The manufacturer of the processor.
     *
     * @var null
     */
    protected $manufacturer;

    /**
     * The speed of the processor.
     *
     * @var null
     */
    protected $speed;

    /**
     * Constructor.
     *
     * @param Computer $computer
     * @param string   $name
     * @param null     $family
     * @param null     $manufacturer
     * @param null     $speed
     */
    public function __construct(Computer $computer, $name = '', $family = null, $manufacturer = null, $speed = null)
    {
        $this->computer = $computer;
        $this->name = $name;
        $this->family = $family;
        $this->manufacturer = $manufacturer;
        $this->speed = $speed;
    }

    /**
     * Creates a new computer processor.
     *
     * @return bool|ComputerProcessor
     */
    public function handle()
    {
        $processor = ComputerProcessor::firstOrNew([
           'computer_id'    => $this->computer->getKey(),
            'name'          => $this->name,
            'family'        => $this->family,
            'manufacturer'  => $this->manufacturer,
            'speed'         => $this->speed,
        ]);

        if ($processor->save()) {
            return $processor;
        }

        return false;
    }
}
