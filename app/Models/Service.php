<?php

namespace App\Models;

class Service extends Model
{
    /**
     * The services table.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The fillable service attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The hasMany service records relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records()
    {
        return $this->hasMany(ServiceRecord::class, 'service_id');
    }

    /**
     * Returns the last known status for the current service.
     *
     * @return null|string
     */
    public function getLastRecordStatusAttribute()
    {
        if ($this->records->count() > 0) {
            $record = $this->records->first();

            return $record->status_label;
        }

        return;
    }
}
