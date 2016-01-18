<?php

namespace App\Models;

class ComputerProcessor extends Model
{
    /**
     * The computer processor table.
     *
     * @var string
     */
    protected $table = 'computer_processors';

    /**
     * The fillable computer processor attributes.
     *
     * @var array
     */
    protected $fillable = [
        'computer_id',
        'name',
        'family',
        'manufacturer',
        'speed',
    ];

    /**
     * The belongsTo computer relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function computer()
    {
        return $this->belongsTo(Computer::class, 'computer_id');
    }
}
