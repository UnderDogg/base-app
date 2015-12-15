<?php

namespace App\Models;

class Favorite extends Model
{
    /**
     * The favorites table.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * The fillable favorite attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'favorable_id',
        'favorable_type',
    ];

    /**
     * The morphTo favorable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorable()
    {
        return $this->morphTo();
    }
}
