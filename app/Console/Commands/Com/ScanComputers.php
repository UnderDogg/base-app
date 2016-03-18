<?php

namespace App\Console\Commands\Com;

use App\Jobs\Com\Computer\CheckConnectivity;
use App\Jobs\Com\Computer\ScanDisks;
use App\Jobs\Com\Computer\ScanProcessor;
use App\Jobs\Computer\CreateStatus;
use App\Models\Computer;
use App\Models\ComputerStatus;
use COM_Exception;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ScanComputers extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computers:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans all computers.';

    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Create a new command instance.
     *
     * @param Computer $computer
     */
    public function __construct(Computer $computer)
    {
        parent::__construct();

        $this->computer = $computer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $computers = $this->computer->with('access')->get();

        $scanned = 0;

        foreach ($computers as $computer) {
            // Check the computers status.
            $status = $this->dispatch(new CreateStatus($computer));

            // Check if the computer is online.
            if ($status instanceof ComputerStatus && $status->online === true) {
                try {
                    // Check the WMI connectivity to the computer.
                    if ($this->dispatch(new CheckConnectivity($computer))) {
                        // Scan the computers disks.
                        $this->dispatch(new ScanDisks($computer));

                        // Scan the computers processor.
                        $this->dispatch(new ScanProcessor($computer));
                    }

                    $this->info(sprintf('Scanned: %s', $computer->name));

                    $scanned++;
                } catch (COM_Exception $e) {
                    //
                }
            }
        }

        $this->info("Successfully scanned $scanned computers.");
    }
}
