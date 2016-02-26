<?php

namespace App\Policies\ActiveDirectory;

use App\Policies\Policy;

class UserPolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'AD User';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Ad Users',
        'Create Ad User',
    ];

    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
     *
     * @return bool
     */
    public function index()
    {
        return $this->canIf('view-ad-users');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory users.
     *
     * @return bool
     */
    public function store()
    {
        return $this->canIf('create-ad-user');
    }
}
