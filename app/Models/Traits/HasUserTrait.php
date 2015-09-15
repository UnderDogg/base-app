<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasUserTrait
{
    /**
     * The hasOne user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
