<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasUsers
{
    /**
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->getUsersPivotTable());
    }

    /**
     * Returns the users pivot table for the inherited model.
     *
     * @return string
     */
    abstract public function getUsersPivotTable();
}
