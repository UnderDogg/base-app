<?php

namespace App\Jobs\Com\Computer;

use App\Jobs\Computer\CreateAccess;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Stevebauman\Wmi\Schemas\Namespaces;

class CheckConnectivity extends AbstractComputerJob
{
    use DispatchesJobs;

    /**
     * Tries to connect to the specified computer through WMI.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->wmi->connect(Namespaces::ROOT_CIMV2)) {
            $this->dispatch(new CreateAccess($this->computer, $ad = true, $wmi = true, $this->username, $this->password));

            return true;
        }

        return false;
    }
}
