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

            $favorite->user_id = auth()->user()->id;

            return $this->favorites()->save($favorite);
        }

        return false;
    }

    /**
     * Un-favorites the current model by deleting the favorite.
     *
     * @return bool
     */
    public function unFavorite()
    {
        $favorite = $this->hasFavorite();

        if ($favorite instanceof Favorite) {
            return $favorite->delete();
        }

        return false;
    }

    /**
     * Returns true / false if the current model
     * is favorited by the current user.
     *
     * @return bool|Favorite
     */
    public function hasFavorite()
    {
        $favorite = $this->favorites()
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($favorite instanceof Favorite) {
            return $favorite;
        }

        return false;
    }

    /**
     * Returns the favorite icon.
     *
     * @return string
     */
    public function getFavoriteIcon()
    {
        if ($this->hasFavorite()) {
            $class = 'fa fa-star';
        } else {
            $class = 'fa fa-star-o';
        }

        return "<i class='$class'></i>";
    }
}
