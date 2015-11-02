<?php

namespace App\Models;

use Baum\Node;

class DriveItem extends Node
{
    /**
     * The drive items nested set table.
     *
     * @var string
     */
    protected $table = 'drive_items';

    /**
     * The belongsToMany accounts relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->hasMany(DriveItemAccount::class, 'item_id');
    }
}
