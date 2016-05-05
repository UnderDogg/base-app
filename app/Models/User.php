<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasFilesTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Larapacks\Authorization\Traits\UserRolesTrait;
use Orchestra\Support\Facades\HTML;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable;
    use Authenticatable;
    use UserRolesTrait;
    use AdldapUserModelTrait;
    use HasFilesTrait;
    use HasAvatar;

    /**
     * The users hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'email',
        'password',
        'remember_token',
        'from_ad',
    ];

    /**
     * {@inheritdoc}
     */
    public function avatars()
    {
        return $this->files();
    }

    /**
     * The hasOne password folder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passwordFolder()
    {
        return $this->hasOne(PasswordFolder::class);
    }

    /**
     * Scopes the specified query limited to administrators.
     *
     * @param mixed $query
     *
     * @return mixed
     */
    public function scopeWhereIsAdministrator($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where(['name' => Role::getAdministratorName()]);
        });
    }

    /**
     * Returns the users initials.
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        $expr = '/(?<=\s|^)[a-z]/i';

        preg_match_all($expr, $this->name, $matches);

        $result = implode('', $matches[0]);

        return strtoupper($result);
    }

    /**
     * Returns an HTML string of the users label.
     *
     * @return string
     */
    public function getLabelAttribute()
    {
        $color = 'primary';

        $name = HTML::entities($this->name);

        $icon = HTML::create('i', '', ['class' => 'fa fa-user']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Returns a large variant of the users label.
     *
     * @return string
     */
    public function getLabelLargeAttribute()
    {
        return HTML::create('span', $this->label, ['class' => 'label-large']);
    }
}
