<?php

namespace App\Models;

class ComputerAccess extends Model
{
    /**
     * The computer access table.
     *
     * @var string
     */
    protected $table = 'computer_access';

    /**
     * The fillable computer access attributes.
     *
     * @var array
     */
    protected $fillable = [
        'active_directory',
        'wmi'
    ];
}
