<?php

namespace App\Console\Commands\ActiveDirectory;

use Adldap\Laravel\Facades\Adldap;
use App\Jobs\ActiveDirectory\ImportComputer;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncComputers extends Command
{
    use DispatchesJobs;

    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'computers:sync';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Synchronize active directory computers.';

    /**
     * Execute the command.
     */
    public function handle()
    {
        $computers = Adldap::search()->computers()->get();

        $i = 0;

        foreach ($computers as $computer) {
            if ($this->dispatch(new ImportComputer($computer))) {
                ++$i;
            }
        }

        $this->info("Successfully synchronized: $i computers.");
    }
}
