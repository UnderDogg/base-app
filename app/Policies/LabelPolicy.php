<?php

namespace App\Policies;

class LabelPolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View All Labels',
        'Create Label',
        'Edit Label',
        'Delete Label',
    ];

    /**
     * Allows users with specific permission
     * to view all labels.
     *
     * @return bool
     */
    public function index()
    {
        return $this->can('view-all-labels');
    }

    /**
     * Allows users with specific permission
     * to create labels.
     *
     * @return bool
     */
    public function create()
    {
        return $this->can('create-label');
    }

    /**
     * Allows users with specific permission
     * to create labels.
     *
     * @return bool
     */
    public function store()
    {
        return $this->create();
    }

    /**
     * Allows users with specific permission
     * to edit labels.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->can('edit-label');
    }

    /**
     * Allows users with specific permission
     * to update labels.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Allows users with specific permission
     * to delete labels.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->can('delete-label');
    }
}
