<?php

namespace App\Models;

class ServiceRecord extends Model
{
    /**
     * The service records table.
     *
     * @var string
     */
    protected $table = 'service_records';

    /**
     * The belongsTo service relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
