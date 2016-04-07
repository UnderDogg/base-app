<?php

namespace App\Jobs\Computer;

use App\Jobs\Job;
use App\Models\Computer;
use App\Models\ComputerAccess;

class CreateAccess extends Job
{
    /**
     * The computer to create an access record on.
     *
     * @var Computer
     */
    protected $computer;

    /**
     * The bool to determine whether the computer
     * can be accessed via active directory.
     *
     * @var bool|false
     */
    protected $ad = false;

    /**
     * The bool to determine whether the computer
     * can be accessed via WMI.
     *
     * @var bool|false
     */
    protected $wmi = false;

    /**
     * The WMI Username to use to access the computer.
     *
     * @var string|null
     */
    protected $wmiUsername = null;

    /**
     * The WMI Password to use to access the computer.
     *
     * @var string|null
     */
    protected $wmiPassword = null;

    /**
     * Constructor.
     *
     * @param Computer    $computer
     * @param bool|false  $ad
     * @param bool|false  $wmi
     * @param string|null $wmiUsername
     * @param string|null $wmiPassword
     */
    public function __construct(Computer $computer, $ad = false, $wmi = false, $wmiUsername = null, $wmiPassword = null)
    {
        $this->computer = $computer;
        $this->ad = $ad;
        $this->wmi = $wmi;
        $this->wmiUsername = $wmiUsername;
        $this->wmiPassword = $wmiPassword;
    }

    /**
     * Creates a computer access record.
     *
     * @param ComputerAccess $access
     *
     * @return ComputerAccess|bool
     */
    public function handle(ComputerAccess $access)
    {
        $access = $access->firstOrNew(['computer_id' => $this->computer->id]);

        $access->active_directory = $this->ad;
        $access->wmi = $this->wmi;
        $access->wmi_username = $this->wmiUsername;
        $access->wmi_password = $this->wmiPassword;

        if ($access->save()) {
            return $access;
        }

        return false;
    }
}
