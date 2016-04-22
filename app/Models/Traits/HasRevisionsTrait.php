<?php

namespace App\Models\Traits;

use Stevebauman\Revision\Traits\HasRevisionsTrait as BaseRevisionsTrait;
use App\Models\Revision;
use Illuminate\Support\Facades\Auth;

trait HasRevisionsTrait
{
    use BaseRevisionsTrait;

    /**
     * The morphed to many revisions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function revisions()
    {
        return $this->morphMany(Revision::class, 'revisionable');
    }

    /**
     * Returns the revisions user ID.
     *
     * @return int
     */
    public function revisionUserId()
    {
        return Auth::id();
    }
}
