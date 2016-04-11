<?php

namespace App\Models\Traits;

use App\Models\Comment;

trait HasCommentsTrait
{
    /**
     * The belongsToMany comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, $this->getCommentsPivotTable());
    }

    /**
     * Returns the comments pivot table for the inherited model.
     *
     * @return string
     */
    abstract public function getCommentsPivotTable();
}
