<?php

namespace App\Jobs\Com\Computer;

use App\Jobs\Computer\CreateDisk;
use App\Jobs\Computer\CreateDiskRecord;
use App\Models\ComputerHardDisk;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Stevebauman\Wmi\ConnectionInterface;
use Stevebauman\Wmi\Models\Variants\HardDisk;
use Stevebauman\Wmi\Schemas\Namespaces;

class ScanDisks extends ComputerJob
{
    use DispatchesJobs;

    /**
     * Scans the current computers hard disks and creates a record of them.
     *
     * @return bool|array
     */
    public function handle()
    {
        try {
            // Try to connect to the machine.
            $connection = $this->wmi->connect(Namespaces::ROOT_CIMV2);

            // Check that we're connected to the machine.
            if ($connection instanceof ConnectionInterface) {
                // Get the machines hard disks.
                $disks = $connection->hardDisks()->get();

                $added = [];

                foreach ($disks as $disk) {
                    // Go through each disk and create a new
                    // disk record for the current computer.
                    if ($disk instanceof HardDisk) {
                        // Make sure we skip drive type 5 since it's a CD-ROM drive
                        if ($disk->getDriveType() !== 5) {
                            $job = new CreateDisk($this->computer, $disk->getName(), $disk->getSize(), $disk->getInstallDate(), $disk->getDescription());

                            $hd = $this->dispatch($job);

                            if ($hd instanceof ComputerHardDisk) {
                                // If a hard disk is successfully created, we'll
                                // dispatch the job to create a new disk record.
                                $this->dispatch(new CreateDiskRecord($hd, $disk->getFreeSpace(), $disk->getStatus()));
                            }

                            $added[] = $hd;
                        }
                    }
                }

                return $added;
            }
        } catch (\COM_EXCEPTION $e) {
            //
        }

        return false;
    }
}
