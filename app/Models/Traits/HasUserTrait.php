<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Scopes the current query by the specified user.
     *
     * @param Builder $query
     * @param User    $user
     *
     * @return Builder
     */
    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where(['user_id' => $user->id]);
    }
}
