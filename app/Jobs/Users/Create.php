<?php

namespace App\Jobs\Users;

use App\Models\User;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class Create extends Job implements SelfHandling
{
    /**
     * The users email;
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
    protected $fullName;

    /**
     * Constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $fullName
     */
    public function __construct($email, $password, $fullName = null)
    {
        $this->email = $email;
        $this->password = bcrypt($password);
        $this->fullName = $fullName;
    }

    /**
     * Creates a new user.
     *
     * @param User $user
     *
     * @return User|bool|static
     */
    public function handle(User $user)
    {
        $exists = $user->where('email', $this->email)->first();

        if (!$exists) {
            $user->email = $this->email;
            $user->password = $this->password;
            $user->fullname = $this->fullName;

            if ($user->save()) {
                return $user;
            }
        }

        return false;
    }
}
