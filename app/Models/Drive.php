<?php

namespace App\Models;

class Drive extends Model
{
    /**
     * The drives table.
     *
     * @var string
     */
    protected $table = 'drives';

    /**
     * The fillable drive attributes.
     *
     * @var array
     */
    protected $fillable = ['name', 'path'];
}
