<?php

namespace App\Console\Commands\ActiveDirectory;

use Adldap\Contracts\Adldap;
use Adldap\Models\Group;
use App\Jobs\ActiveDirectory\ImportGroup;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncRole extends Command
{
    use DispatchesJobs;

    /**
     * The command signature
     *
     * @var string
     */
    protected $signature = 'roles:sync {group-name}';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes Active Directory groups with local roles.';

    /**
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
        $group = $this->adldap->groups()->find($this->argument('group-name'));

        if ($group instanceof Group) {
            if($this->dispatch(new ImportGroup($group))) {
                $this->info("Successfully imported group: {$group->getName()}");
            }
        } else {
            $this->info('Error, there was an issue finding the specified group.');
        }
    }
}
