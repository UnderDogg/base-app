<?php

namespace App\Policies\ActiveDirectory;

use App\Policies\Policy;

class AccessPolicy extends Policy
{
    /**
     * The policy display name.
     *
     * @var string
     */
    protected $name = 'AD Access';

    /**
     * The policy actions.
     *
     * @var array
     */
    public $actions = [
        'Access AD Functions',
    ];

    /**
     * Returns true / false if the specified
     * user can access Active Directory
     * functionality.
     *
     * @return bool
     */
    public function access()
    {
        return $this->canIf('access-ad-functions');
    }
}
