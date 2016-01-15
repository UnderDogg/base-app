<?php

namespace App\Console\Commands;

use App\Jobs\Com\Computer\ScanDisks;
use App\Jobs\Computer\CreateStatus;
use App\Models\Computer;
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
            $this->dispatch(new CreateStatus($computer));

            // Scan the computers disks
            $this->dispatch(new ScanDisks($computer));

            ++$scanned;
        }

        $this->info("Successfully scanned $scanned computers.");
    }
}
