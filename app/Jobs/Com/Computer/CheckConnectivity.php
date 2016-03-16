<?php

namespace App\Jobs\Com\Computer;

use App\Jobs\Computer\CreateAccess;
use Stevebauman\Wmi\Schemas\Namespaces;

class CheckConnectivity extends AbstractComputerJob
{
    /**
     * Tries to connect to the specified computer through WMI.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->wmi->connect(Namespaces::ROOT_CIMV2)) {
            return true;
        }

        return false;
    }
}
