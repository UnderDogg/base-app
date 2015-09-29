<?php

namespace App\Jobs\ActiveDirectory;

use App\Models\ComputerAccess;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateComputerAccess extends Job implements SelfHandling
{
    /**
     * The computer ID.
     *
     * @var int
     */
    protected $computerId;

    /**
     * Constructor.
     *
     * @param int|string $computerId
     */
    public function __construct($computerId)
    {
        $this->computerId = $computerId;
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

        $access->active_directory = true;

        if ($access->save()) {
            return $access;
        }

        return false;
    }
}
