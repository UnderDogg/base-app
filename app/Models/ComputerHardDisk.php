<?php

namespace App\Models;

class ComputerHardDisk extends Model
{
    /**
     * The computer hard disk table.
     *
     * @var string
     */
    protected $table = 'computer_hard_disks';

    /**
     * The fillable computer hard disk attributes.
     *
     * @var array
     */
    protected $fillable = [
        'computer_id'
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
