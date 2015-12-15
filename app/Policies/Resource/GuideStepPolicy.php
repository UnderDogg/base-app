<?php

namespace App\Policies\Resource;

use App\Policies\Policy;

class GuideStepPolicy extends Policy
{
    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View All Steps',
    ];

    /**
     * Allows users with specific permission
     * to view all guide steps.
     *
     * @return bool
     */
    public function index()
    {
        return $this->can('view-all-steps');
    }
}
