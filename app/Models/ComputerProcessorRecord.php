<?php

namespace App\Models;

class ComputerProcessorRecord extends Model
{
    /**
     * The computer processor records table.
     *
     * @var string
     */
    protected $table = 'computer_processor_records';

    /**
     * The belongsTo processor relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processor()
    {
        return $this->belongsTo(ComputerProcessor::class, 'processor_id');
    }
}
