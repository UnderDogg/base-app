<?php

namespace App\Models\Traits;

use App\Models\Upload;

trait HasAvatar
{
    /**
     * The morphMany images relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function avatars();

    /**
     * Returns the users avatar upload if it exists.
     *
     * @return Upload|null
     */
    public function avatar()
    {
        return $this->avatars()->first();
    }

    /**
     * Adds an avatar by the specified file path.
     *
     * @param string $path
     *
     * @return Upload
     */
    public function addAvatar($path)
    {
        return $this->addFile('avatar', 'image/jpeg', 2000, $path);
    }

    /**
     * The users avatar URL accessor.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return route('profile.avatar.download', [$this->id]);
    }

    /**
     * Returns true / false if the current user has an avatar.
     *
     * @return bool
     */
    public function getHasAvatarAttribute()
    {
        return $this->avatar() instanceof Upload;
    }
}
