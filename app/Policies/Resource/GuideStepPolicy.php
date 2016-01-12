<?php

namespace App\Policies\Resource;

use App\Policies\Policy;

class GuideStepPolicy extends Policy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'Guide Step Policy';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View All Steps',
        'Create Step',
        'Create Steps With Images',
        'Edit Step',
        'Move Step',
        'Delete Step',
    ];

    /**
     * Allows users with specific permission
     * to view all guide steps.
     *
     * @return bool
     */
    public function index()
    {
        return $this->canIf('view-all-steps');
    }

    /**
     * Allows users with specific permission
     * to create guide steps.
     *
     * @return bool
     */
    public function create()
    {
        return $this->canIf('create-step');
    }

    /**
     * Allows users with specific permission
     * to edit guide steps.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->canIf('edit-step');
    }

    /**
     * Allows users with specific permission
     * to update guide steps.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Allows users with specific permission
     * to create guide steps with images.
     *
     * @return bool
     */
    public function images()
    {
        return $this->canIf('create-steps-with-images');
    }

    /**
     * Allows users with specific permission
     * to move guide steps.
     *
     * @return bool
     */
    public function move()
    {
        return $this->canIf('move-step');
    }

    /**
     * Allows users with specific permission
     * to delete guide steps.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->canIf('delete-step');
    }
}
