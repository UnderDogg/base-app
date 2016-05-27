<?php

namespace App\Providers;

use Adldap\Laravel\AdldapAuthUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class LdapAuthServiceProvider extends AdldapAuthUserProvider
{
    protected function syncModelPassword(Authenticatable $model, $password)
    {
        //
    }
}
