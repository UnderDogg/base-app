<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;

class Inquiry extends Model
{
    use HasUserTrait;

    /**
     * The requests table.
     *
     * @var string
     */
    protected $table = 'inquiries';

    /**
     * The request comments pivot table.
     *
     * @var string
     */
    protected $tablePivotComments = 'inquiry_comments';

    /**
     * The belongsToMany comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, $this->tablePivotComments);
    }
}
