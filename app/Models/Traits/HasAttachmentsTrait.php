<?php

namespace App\Models\Traits;

use App\Models\Attachment;

trait HasAttachmentsTrait
{
    /**
     * The morphMany attachments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
