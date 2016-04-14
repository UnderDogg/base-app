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
        if (!$computer->deleted_at) {
            $statuses = $computer->statuses()->get();

            foreach ($statuses as $status) {
                $status->delete();
            }
        }
    }
}
