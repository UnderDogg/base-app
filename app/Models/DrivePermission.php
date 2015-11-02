<?php

namespace App\Models;

class DrivePermission extends Model
{
    /**
     * The drive permissions table.
     *
     * @var string
     */
    protected $table = 'drive_permissions';

    /**
     * The fillable drive permission attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
