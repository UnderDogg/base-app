<?php

namespace App\Jobs\ActiveDirectory;

use Adldap\Models\User as AdUser;
use App\Jobs\Job;
use App\Jobs\User\Create as CreateUser;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ImportUser extends Job
{
    use DispatchesJobs;

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
        $exists = $user->where('email', $this->user->getEmail())->first();

        if (!$exists) {
            $email = $this->user->getEmail();
            $password = str_random(40);
            $fullName = $this->user->getName();

            return $this->dispatch(new CreateUser($email, $password, $fullName));
        }

        return false;
    }
}
