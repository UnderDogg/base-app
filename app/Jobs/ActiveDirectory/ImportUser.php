<?php

namespace App\Jobs\ActiveDirectory;

use Adldap\Models\User as AdUser;
use App\Jobs\Job;
use App\Jobs\User\Create as CreateUser;
use App\Models\User;

class ImportUser extends Job
{
    /**
     * @var AdUser
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param AdUser $user
     */
    public function __construct(AdUser $user)
    {
        $this->user = $user;
    }

    /**
     * Imports an active directory user.
     *
     * @param User $user
     *
     * @return bool
     */
    public function handle(User $user)
    {
        $user = $user->where('email', $this->user->getEmail())->first();

        if (!$user instanceof User) {
            $email = $this->user->getEmail();
            $password = str_random(40);
            $fullName = $this->user->getName();

            $user = $this->dispatch(new CreateUser($email, $password, $fullName));
        }

        // Synchronize their AD attributes.
        $user->from_ad = true;

        if ($user->isDirty()) {
            // Check if there's any changed before
            // firing a save to save on inserts.
            $user->save();
        }

        return $user;
    }
}
