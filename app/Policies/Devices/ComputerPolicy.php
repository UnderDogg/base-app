<?php

namespace App\Policies\Devices;

use App\Policies\Policy;

class ComputerPolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View All Computers',
        'Create Computer',
        'Store Computer',
        'View Computer',
        'Edit Computer',
        'Update Computer',
        'Delete Computer',
    ];

    /**
     * Determines if the current user can view all computers.
     *
     * @return bool
     */
    public function index()
    {
        return $this->can('view-all-computers');
    }

    /**
     * Determines if the current user can create computers.
     *
     * @return bool
     */
    public function create()
    {
        return $this->can('create-computer');
    }

    /**
     * Determines if the current user can store computers.
     *
     * @return bool
     */
    public function store()
    {
        return $this->can('store-computer');
    }

    /**
     * Determines if the current user can view computers.
     *
     * @return bool
     */
    public function show()
    {
        return $this->can('view-computer');
    }

    /**
     * Determines if the current user can edit computers.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->can('edit-computer');
    }

    /**
     * Determines if the current user can update computers.
     *
     * @return bool
     */
    public function update()
    {
        return $this->can('update-computer');
    }

    /**
     * Determines if the current user can destroy computers.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->can('delete-computer');
    }
}
