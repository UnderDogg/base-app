<?php

namespace App\Jobs\Computers;

use App\Models\OperatingSystem;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateOs extends Job implements SelfHandling
{
    /**
     * @var string
     */
    protected $name;

    /**
     * The operating system version.
     *
     * @var string
     */
    protected $version;

    /**
     * The operating system service pack.
     *
     * @var string
     */
    protected $servicePack;

    /**
     * Constructor.
     *
     * @param string      $name
     * @param string      $version
     * @param null|string $servicePack
     */
    public function __construct($name, $version, $servicePack = null)
    {
        $this->name = $name;
        $this->version = $version;
        $this->servicePack = $servicePack;
    }

    /**
     * Creates an operating system.
     *
     * @return OperatingSystem
     */
    public function handle()
    {
        return OperatingSystem::firstOrCreate([
            'name' => $this->name,
            'version' => $this->version,
            'service_pack' => $this->servicePack,
        ]);
    }
}
