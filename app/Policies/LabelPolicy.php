<?php

namespace App\Policies;

class LabelPolicy extends Policy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'Label Policy';

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
        return $this->canIf('view-all-labels');
    }

    /**
     * Allows users with specific permission
     * to create labels.
     *
     * @return bool
     */
    public function create()
    {
        return $this->canIf('create-label');
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
        return $this->canIf('edit-label');
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
        return $this->canIf('delete-label');
    }
}
