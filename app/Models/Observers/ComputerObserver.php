<?php

namespace App\Models\Observers;

use App\Models\Computer;

class ComputerObserver extends Observer
{
    /**
     * Catches and runs operations when a computer is deleted.
     *
     * @param Computer $computer
     */
    public function deleting(Computer $computer)
    {
        $computer->access()->delete();

        $disks = $computer->disks()->get();

        foreach ($disks as $disk) {
            $disk->delete();
        }

        $statuses = $computer->statuses()->get();

        foreach ($statuses as $status) {
            $status->delete();
        }
    }
}
