<?php

namespace App\Policies\ActiveDirectory;

use App\Policies\Policy;

class ComputerPolicy extends Policy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'AD Computer';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Computers',
        'Create Computer',
        'Import All Computers',
    ];

    /**
     * Returns true / false if the specified user
     * can view all active directory computers.
     *
     * @return bool
     */
    public function index()
    {
        return $this->canIf('view-computers');
    }

    /**
     * Returns true / false if the specified user
     * can add active directory computers.
     *
     * @return bool
     */
    public function store()
    {
        return $this->canIf('create-computer');
    }

    /**
     * Returns true / false if the specified user
     * can add all active directory computers.
     *
     * @return bool
     */
    public function storeAll()
    {
        return $this->canIf('import-all-computers');
    }
}
