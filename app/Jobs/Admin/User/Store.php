<?php

namespace App\Jobs\Admin\User;

use App\Http\Requests\Admin\UserRequest;
use App\Jobs\Job;
use App\Models\User;

class Store extends Job
{
    /**
     * @var UserRequest
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param UserRequest $request
     * @param User        $user
     */
    public function __construct(UserRequest $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->user->name = $this->request->input('name');
        $this->user->email = $this->request->input('email');

        $password = $this->request->input('password');

        // If the user doesn't have a set password mutator,
        // we'll encrypt the password.
        if (!$this->user->hasSetMutator('password')) {
            $password = bcrypt($password);
        }

        $this->user->password = $password;

        return $this->user->save();
    }
}
