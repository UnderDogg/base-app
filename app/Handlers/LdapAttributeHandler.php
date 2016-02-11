<?php

namespace App\Handlers;

use Adldap\Models\User;

class LdapAttributeHandler extends Handler
{
    /**
     * Returns true to synchronize the `from_ad`
     * attribute on the users table.
     *
     * @param User $user
     *
     * @return bool
     */
    public function fromAd(User $user)
    {
        return true;
    }

    /**
     * Returns the AD users account name to synchronize
     * the `ad_username` attribute on the users table.
     *
     * @param User $user
     *
     * @return string
     */
    public function adUsername(User $user)
    {
        return $user->getAccountName();
    }
}
