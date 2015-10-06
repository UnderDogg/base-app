<?php

namespace App\Jobs\Computers;

use Stevebauman\Wmi\ConnectionInterface;
use Stevebauman\Wmi\Schemas\Namespaces;
use Stevebauman\Wmi\Wmi;
use App\Models\Computer;
use App\Models\ComputerHardDisk;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateDisk extends Job implements SelfHandling
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer $computer
     */
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    public function handle()
    {
        // Check if the computer can be accessed by WMI.
        if ($this->computer->getWmiAccess()) {
            // Check if the access record contains a username and password
            if ($this->computer->access->wmi_username && $this->computer->access->wmi_password) {
                $username = $this->computer->access->wmi_username;
                $password = $this->computer->access->wmi_password;
            } else {
                $username = config('adldap.admin_username');
                $password = config('adldap.admin_password');
            }

            // Create a new WMI instance on the computer
            $wmi = new Wmi($this->computer->name, $username, $password);

            // Try to connect to the machine
            $connection = $wmi->connect(Namespaces::ROOT_CIMV2);

            if ($connection instanceof ConnectionInterface) {
                //
            }
        }

        return false;
    }
}
