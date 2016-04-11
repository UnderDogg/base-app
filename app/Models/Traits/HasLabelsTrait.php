<?php

namespace App\Models\Traits;

use App\Models\Label;

trait HasLabelsTrait
{
    /**
     * The belongsToMany labels relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, $this->getLabelsPivotTable());
    }

    /**
     * Returns the labels pivot table for the inherited model.
     *
     * @return string
     */
    abstract public function getLabelsPivotTable();
}
