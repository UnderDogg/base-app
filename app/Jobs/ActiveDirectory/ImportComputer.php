<?php

namespace App\Jobs\ActiveDirectory;

use App\Jobs\Computers\Create as CreateComputer;
use App\Jobs\Computers\CreateOs;
use App\Jobs\Computers\CreateType;
use App\Jobs\Job;
use Adldap\Models\Computer as AdComputer;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ImportComputer extends Job implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var AdComputer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param AdComputer $computer
     */
    public function __construct(AdComputer $computer)
    {
        $this->computer = $computer;
    }

    /**
     * Creates a computer from an AD Computer model instance.
     *
     * @return \App\Models\Computer
     */
    public function handle()
    {
        $operatingSystem = $this->computer->getOperatingSystem();
        $version = $this->computer->getOperatingSystemVersion();
        $servicePack = $this->computer->getOperatingSystemServicePack();

        $os = $this->dispatch(new CreateOs($operatingSystem, $version, $servicePack));
        $type = $this->dispatch((new CreateType(null))->fromOs($operatingSystem));

        $name = $this->computer->getName();
        $description = $this->computer->getDescription();
        $dn = $this->computer->getDn();

        $job = new CreateComputer($type->getKey(), $os->getKey(), $name, $description, $dn);

        return $this->dispatch($job);
    }
}
