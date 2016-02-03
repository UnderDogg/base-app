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
     * The hasMany service records relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records()
    {
        return $this->hasMany(ServiceRecord::class, 'service_id');
    }
}
