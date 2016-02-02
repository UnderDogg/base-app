<?php

namespace App\Models;

class ComputerHardDiskRecord extends Model
{
    /**
     * The computer hard disk records table.
     *
     * @var string
     */
    protected $table = 'computer_hard_disk_records';

    /**
     * The fillable computer hard disk record attributes.
     *
     * @var array
     */
    protected $fillable = [
        'disk_id',
    ];

    /**
     * The belongsTo disk relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disk()
    {
        return $this->belongsTo(ComputerHardDisk::class, 'disk_id');
    }

    /**
     * The rounded space free attribute accessor.
     *
     * @return string
     */
    public function getFreeRoundedAttribute()
    {
        $size = $this->free;

        if (is_numeric($this->free)) {
            return round(($size  / (1024 * 1024 * 1024)), 2);
        }

        return 0;
    }
}
