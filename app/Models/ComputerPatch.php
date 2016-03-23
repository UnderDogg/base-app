<?php

namespace App\Models;

class ComputerPatch extends Model
{
    /**
     * The computer patch table.
     *
     * @var string
     */
    protected $table = 'computer_patches';

    /**
     * The fillable computer patch attributes.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The belongsTo computer relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
