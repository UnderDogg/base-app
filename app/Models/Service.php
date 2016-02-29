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
        return $this->hasMany(ServiceRecord::class, 'service_id')->latest();
    }

    /**
     * Returns the last service record.
     *
     * @return null|ServiceRecord
     */
    public function getLastRecordAttribute()
    {
        if ($this->records->count() > 0) {
            return $this->records->first();
        }
    }

    /**
     * Returns the last known status for the current service.
     *
     * @return string
     */
    public function getLastRecordStatusAttribute()
    {
        $record = $this->last_record;

        if ($record instanceof ServiceRecord) {
            return $record->status_label;
        }

        $record = new ServiceRecord();

        $record->status = ServiceRecord::STATUS_UNKNOWN;

        return $record->status_label;
    }
}
