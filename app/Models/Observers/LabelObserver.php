<?php

namespace App\Models\Observers;

use App\Models\Label;

class LabelObserver extends Observer
{
    /**
     * Operations to run upon deleting a label.
     *
     * @param Label $label
     */
    public function deleting(Label $label)
    {
        if (!$label->deleted_at) {
            $label->issues()->detach();
        }

    }
}
