<?php

namespace App\Models;

use Stevebauman\Authorization\Traits\PermissionRolesTrait;

class Permission extends Model
{
    use PermissionRolesTrait;

    /**
     * The permissions table.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The fillable permission attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
    ];
}
