<?php

namespace App\Models;

class Attachment extends Model
{
    /**
     * The attachments table.
     *
     * @var string
     */
    protected $table = 'attachments';

    /**
     * The morphTo attachable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
