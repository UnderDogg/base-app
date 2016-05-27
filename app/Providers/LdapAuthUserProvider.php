<?php

namespace App\Providers;

use Adldap\Laravel\AdldapAuthUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class LdapAuthUserProvider extends AdldapAuthUserProvider
{
    protected function syncModelPassword(Authenticatable $model, $password)
    {
        //
    }
}
