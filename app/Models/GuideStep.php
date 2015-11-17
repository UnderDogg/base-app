<?php

namespace App\Models;

use Rutorika\Sortable\SortableTrait;

class GuideStep extends Model
{
    use SortableTrait;

    /**
     * The guide steps model.
     *
     * @var string
     */
    protected $table = 'guide_steps';

    /**
     * The belongsTo guide relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }
}
