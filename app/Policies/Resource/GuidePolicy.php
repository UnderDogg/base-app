<?php

namespace App\Policies\Resource;

use App\Models\Guide;
use App\Policies\Policy;

class GuidePolicy extends Policy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'Guides';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Unpublished',
        'View Guide',
        'Create Guide',
        'Edit Guide',
        'Delete Guide',
    ];

    /**
     * Allows only users with specific permission
     * to view guides that are unpublished.
     *
     * @param Guide|null $guide
     *
     * @return bool
     */
    public function viewUnpublished(Guide $guide = null)
    {
        if ($guide instanceof Guide && $guide->published) {
            return true;
        }

        return $this->canIf('view-unpublished');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @return bool
     */
    public function create()
    {
        return $this->canIf('create-guide');
    }

    /**
     * Allows only users with specific permission to create guides.
     *
     * @return bool
     */
    public function store()
    {
        return $this->create();
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->canIf('edit-guide');
    }

    /**
     * Allows only users with specific permission to edit guides.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Allows only users with specific permission to delete guides.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->canIf('delete-guide');
    }
}
