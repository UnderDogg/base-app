<?php

namespace App\Models;

class DriveAccount extends Model
{
    /**
     * The drive accounts table.
     *
     * @var string
     */
    protected $table = 'drive_accounts';

    /**
     * The drive account attribute casts.
     *
     * @var array
     */
    protected $casts = ['permissions' => 'object'];
}
