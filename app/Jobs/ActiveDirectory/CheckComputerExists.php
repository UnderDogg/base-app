<?php

namespace App\Jobs\ActiveDirectory;

use Adldap\Laravel\Facades\Adldap;
use Adldap\Models\Computer;
use App\Jobs\Job;

class CheckComputerExists extends Job
{
    /**
     * The computers name to check.
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * Returns true / false if the specified
     * computer exists in active directory.
     *
     * @return bool
     */
    public function handle()
    {
        $computer =  Adldap::search()->computers()->find($this->name);

        return $computer instanceof Computer;
    }
}
