<?php

namespace App\Models;

class Event extends Model
{
    /**
     * The events table.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The fillable event attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'eventable_id',
        'eventable_type',
    ];

    /**
     * The morphTo eventable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function eventable()
    {
        return $this->morphTo();
    }
}
