<?php

namespace App\Models\Observers;

use App\Models\GuideStep;

class GuideStepObserver extends Observer
{
    /**
     * Catches and runs operations when a guide step is deleted.
     *
     * @param GuideStep $step
     */
    public function deleting(GuideStep $step)
    {
        $files = $step->images()->get();

        foreach ($files as $file) {
            $file->delete();
        }
    }
}
