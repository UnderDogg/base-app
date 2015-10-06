<?php

namespace App\Models;

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
}
