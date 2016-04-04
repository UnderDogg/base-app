<?php

namespace App\Console\Commands\ActiveDirectory;

use Adldap\Contracts\AdldapInterface;
use App\Jobs\ActiveDirectory\ImportUser;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncUsers extends Command
{
    use DispatchesJobs;

    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'users:sync';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Synchronize active directory users.';

    /**
     * The Adldap instance.
     *
     * @var AdldapInterface
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param AdldapInterface $adldap
     */
    public function __construct(AdldapInterface $adldap)
    {
        parent::__construct();

        $this->adldap = $adldap;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $users = $this->adldap
            ->getProvider('default')
            ->search()
            ->users()
            ->whereHas('mail')
            ->get();

        $i = 0;

        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($this->dispatch(new ImportUser($user))) {
                    ++$i;
                }
            }
        }

        $this->info("Successfully synchronized: $i users.");
    }
}
