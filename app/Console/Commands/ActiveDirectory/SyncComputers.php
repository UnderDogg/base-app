<?php

namespace App\Console\Commands\ActiveDirectory;

use Adldap\Contracts\Adldap;
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
     * The Adldap instance.
     *
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param Adldap $adldap
     */
    public function __construct(Adldap $adldap)
    {
        parent::__construct();

        $this->adldap = $adldap;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $computers = $this->adldap
            ->computers()
            ->all();

        $i = 0;

        if (count($computers) > 0) {
            foreach ($computers as $computer) {
                if ($this->dispatch(new ImportComputer($computer))) {
                    ++$i;
                }
            }
        }

        $this->info("Successfully synchronized: $i computers.");
    }
}
