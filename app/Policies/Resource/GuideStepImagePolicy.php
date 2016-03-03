<?php

namespace App\Policies\Resource;

use App\Models\User;

class GuideStepImagePolicy
{
    /**
     * Returns true / false if the specified
     * user can delete guide step images.
     *
     * @param User $user
     *
     * @return bool
     */
    public static function destroy(User $user)
    {
        return $user->can('guides.steps.images.destroy');
    }
}
