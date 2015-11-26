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
        $steps = $guide->steps()->get();

        foreach ($steps as $step) {
            $step->delete();
        }
    }
}
