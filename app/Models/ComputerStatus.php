<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ComputerStatus extends Model
{
    /**
     * The computer status table.
     *
     * @var string
     */
    protected $table = 'computer_status_records';

    /**
     * The belongsTo computer ID.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    /**
     * Scopes the specified query by the current hour.
     *
     * @param Builder $query
     * @param int     $hours
     *
     * @return $this
     */
    public function scopeHourly(Builder $query, $hours = 1)
    {
        return $query->where('created_at', '>=',  Carbon::now()->subHours($hours));
    }

    /**
     * Returns the human readable online attribute.
     *
     * @return string
     */
    public function getOnlineHumanAttribute()
    {
        return ($this->online ? 'Online' : 'Offline');
    }
}
