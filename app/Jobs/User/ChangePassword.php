<?php

namespace App\Jobs\User;

use App\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class ChangePassword implements SelfHandling
{
    /**
     * @var User
     */
    protected $user;

    /**
     * The new password to set the specified
     * users password to.
     *
     * @var string
     */
    private $password;

    /**
     * Constructor.
     *
     * @param User   $user
     * @param string $password
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Changes the specified users password.
     *
     * @return bool
     */
    public function handle()
    {
        $this->user->password = $this->password;

        return $this->user->save();
    }
}
