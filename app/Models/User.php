<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use App\Models\Presenters\UserPresenter;
use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasFilesTrait;
use App\Models\Traits\HasPresenter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Larapacks\Authorization\Traits\UserRolesTrait;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable,
        Authenticatable,
        UserRolesTrait,
        AdldapUserModelTrait,
        HasFilesTrait,
        HasAvatar,
        HasPresenter;

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
     * Retutns a new user presenter instance.
     *
     * @return UserPresenter
     */
    public function present()
    {
        return new UserPresenter($this);
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
}
