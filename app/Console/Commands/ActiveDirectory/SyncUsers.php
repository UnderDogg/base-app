<?php

namespace App\Console\Commands\ActiveDirectory;

use Adldap\Laravel\Facades\Adldap;
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
     * Execute the command.
     */
    public function handle()
    {
        $users = Adldap::search()->users()
            ->whereHas('mail')
            ->whereObjectclass('user')
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
