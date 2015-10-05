<?php

namespace App\Jobs\Computers;

use App\Models\ComputerAccess;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateAccess extends Job implements SelfHandling
{
    /**
     * The computer ID.
     *
     * @var int
     */
    protected $computerId;

    /**
     * The bool to determine whether the computer
     * can be accessed via active directory.
     *
     * @var bool|false
     */
    protected $activeDirectory = false;

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
     * @param int|string  $computerId
     * @param bool|false  $activeDirectory
     * @param bool|false  $wmi
     * @param string|null $wmiUsername
     * @param string|null $wmiPassword
     */
    public function __construct($computerId, $activeDirectory = false, $wmi = false, $wmiUsername = null, $wmiPassword = null)
    {
        $this->computerId = $computerId;
        $this->activeDirectory = $activeDirectory;
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
        $access = $access->firstOrNew(['computer_id' => $this->computerId]);

        $access->active_directory = $this->activeDirectory;
        $access->wmi = $this->wmi;
        $access->wmi_username = $this->wmiUsername;
        $access->wmi_password = $this->wmiPassword;

        if ($access->save()) {
            return $access;
        }

        return false;
    }
}
