<?php

namespace App\Models\Observers;

use App\Models\ComputerHardDisk;

class ComputerHardDiskObserver extends Observer
{
    /**
     * Catches and runs operations when a computer is deleted.
     *
     * @param ComputerHardDisk $disk
     */
    public function deleting(ComputerHardDisk $disk)
    {
        if (!$disk->deleted_at) {
            $disk->records()->delete();
        }
    }
}
