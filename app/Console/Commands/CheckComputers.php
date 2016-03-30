<?php

namespace App\Console\Commands;

use App\Jobs\Computer\CreateStatus;
use App\Models\Computer;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CheckComputers extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computers:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of all computers.';

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
        $computers = $this->computer->get();

        $checked = 0;

        foreach ($computers as $computer) {
            // Check the computers status.
            $this->dispatch(new CreateStatus($computer));

            $checked++;
        }

        $this->info("Successfully checked $checked computers.");
    }
}
