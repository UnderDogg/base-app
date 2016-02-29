<?php

namespace App\Jobs\User;

use App\Jobs\Job;
use App\Models\User;

class Create extends Job
{
    /**
     * The users email;.
     *
     * @var string
     */
    protected $email;

    /**
     * The users password.
     *
     * @var string
     */
    protected $password;

    /**
     * The users full name.
     *
     * @var null|string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $name
     */
    public function __construct($email, $password, $name = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Creates a new user.
     *
     * @param User $model
     *
     * @return User|bool
     */
    public function handle(User $model)
    {
        $exists = $model->where('email', $this->email)->first();

        if (is_null($exists)) {
            $user = $model->newInstance();

            $user->email = $this->email;
            $user->name = $this->name;

            if ($user->hasSetMutator('password')) {
                // If the user model has a password set mutator, we'll assume
                // the developer is encrypting the passwords themselves.
                $user->password = $this->password;
            } else {
                // Otherwise we'll encrypt the password.
                $user->password = bcrypt($this->password);
            }

            $user->save();

            return $user;
        }

        return false;
    }
}
