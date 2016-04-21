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
        return $this->belongsTo(Computer::class, 'computer_id');
    }

    /**
     * Scopes the specified query by the current hour.
     *
     * @param Builder $query
     *
     * @return $this
     */
    public function scopeHourly(Builder $query)
    {
        $now = Carbon::now();

        return $query->where('created_at', '>=', $now->subHour());
    }
}
