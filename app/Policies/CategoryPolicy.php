<?php

namespace App\Policies;

class CategoryPolicy extends Policy
{
    /**
     * The policy display name.
     *
     * @var string
     */
    protected $name = 'Category';

    /**
     * The policy actions.
     *
     * @var array
     */
    public $actions = [
        'View All Categories',
        'Edit Category',
        'Delete Category',
    ];

    /**
     * Returns true / false if the current user can view all categories.
     *
     * @return bool
     */
    public function index()
    {
        return $this->canIf('view-all-categories');
    }

    /**
     * Returns true / false if the current user can edit categories.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->canIf('edit-category');
    }

    /**
     * Returns true / false if the current user can update categories.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Returns true / false if the current user can delete categories.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->canIf('delete-category');
    }
}
