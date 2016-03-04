<?php

namespace App\Models\Observers;

use App\Models\Guide;

class GuideObserver extends Observer
{
    /**
     * Catches and runs operations when a guide is deleted.
     *
     * @param Guide $guide
     */
    public function deleting(Guide $guide)
    {
        if (!$guide->deleted_at) {
            $steps = $guide->steps()->get();

            foreach ($steps as $step) {
                $step->delete();
            }
        }
    }
}
