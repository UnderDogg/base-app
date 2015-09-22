<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use Orchestra\Support\Facades\HTML;
use Orchestra\Model\User as Eloquent;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Eloquent implements AuthorizableContract
{
    use Authorizable, AdldapUserModelTrait;

    /**
     * Returns an HTML string of the users label.
     *
     * @return string
     */
    public function getLabel()
    {
        $color = 'primary';

        $name = HTML::entities($this->fullname);

        $icon = HTML::create('i', '', ['class' => 'fa fa-user']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Returns a large variant of the users label.
     *
     * @return string
     */
    public function getLabelLarge()
    {
        return HTML::create('span', $this->getLabel(), ['class' => 'label-large']);
    }
}
