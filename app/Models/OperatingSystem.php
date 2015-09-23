<?php

namespace App\Models;

class OperatingSystem extends Model
{
    /**
     * The operating systems table.
     *
     * @var string
     */
    protected $table = 'operating_systems';

    /**
     * The fillable operating system attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'version',
        'service_pack',
    ];
}
