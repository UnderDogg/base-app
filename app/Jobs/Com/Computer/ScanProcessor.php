<?php

namespace App\Jobs\Com\Computer;

use App\Jobs\Computer\CreateProcessor;
use App\Jobs\Computer\CreateProcessorRecord;
use App\Models\ComputerProcessor;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Stevebauman\Wmi\ConnectionInterface;
use Stevebauman\Wmi\Models\Variants\Processor;
use Stevebauman\Wmi\Schemas\Namespaces;

class ScanProcessor extends AbstractComputerJob
{
    use DispatchesJobs;

    /**
     * Scans the current computer for its processor and its current load percentage.
     *
     * @return bool|ComputerProcessor
     */
    public function handle()
    {
        try {
            // Try connecting to the machine.
            $connection = $this->wmi->connect(Namespaces::ROOT_CIMV2);

            // Check that we're connected to the machine.
            if ($connection instanceof ConnectionInterface) {
                $processors = $connection->processors()->get();

                // Retrieve the first processor.
                $processor = current($processors);

                // Make sure we've received a processor instance.
                if ($processor instanceof Processor) {
                    $name = $processor->getName();
                    $family = $processor->getDescription();
                    $manufacturer = $processor->getManufacturer();
                    $speed = $processor->getMaxClockSpeed();

                    // Create the new processor.
                    $processor = $this->dispatch(new CreateProcessor($this->computer, $name, $family, $manufacturer, $speed));

                    // Double check that the processor has been successfully created.
                    if ($processor instanceof ComputerProcessor) {
                        // Retrieve the computers current processes.
                        $processes = $this->dispatch(new Processes($this->computer));

                        // Make sure we have a total load value from the retrieved processes.
                        if (array_key_exists('total', $processes)) {
                            $this->dispatch(new CreateProcessorRecord($processor, $processes['total']));
                        }
                    }

                    return $processor;
                }
            }
        } catch (\COM_EXCEPTION $e) {
            //
        }

        return false;
    }
}
