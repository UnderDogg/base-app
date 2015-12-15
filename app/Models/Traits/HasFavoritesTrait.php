<?php

namespace App\Models\Traits;

use App\Models\Favorite;

trait HasFavoritesTrait
{
    /**
     * The morphMany favorites relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    /**
     * Favorites the current model for the current user.
     *
     * @return bool|Favorite
     */
    public function favorite()
    {
        if (!$this->hasFavorite()) {
            $favorite = new Favorite();

            $favorite->user_id = auth()->user()->getKey();

            return $this->favorites()->save($favorite);
        }

        return false;
    }

    /**
     * Returns true / false if the current model
     * is favorited by the current user.
     *
     * @return bool
     */
    public function hasFavorite()
    {
        $favorite = $this->favorites()
            ->where('user_id', auth()->user()->getKey())
            ->first();

        if ($favorite instanceof  Favorite) {
            return true;
        }

        return false;
    }
}
