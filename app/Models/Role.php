<?php

namespace App\Models;

use Stevebauman\Authorization\Traits\RolePermissionsTrait;

class Role extends Model
{
    use RolePermissionsTrait;

    /**
     * The roles table.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The fillable role attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
    ];

    /**
     * Returns an HTML display label for the current role.
     *
     * @return string
     */
    public function getDisplayLabelAttribute()
    {
        return sprintf('<span class="label label-primary"><i class="fa fa-users"></i> %s</span>', $this->label);
    }
}
