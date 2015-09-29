<?php

namespace App\Models;

use App\Models\Traits\CanEncryptTrait;

class ComputerAccess extends Model
{
    use CanEncryptTrait;

    /**
     * The computer access table.
     *
     * @var string
     */
    protected $table = 'computer_access';

    /**
     * The guarded computer access attributes.
     *
     * @var array
     */
    protected $guarded = ['username', 'password'];

    /**
     * The hidden computer access attributes.
     *
     * @var array
     */
    protected $hidden = ['username', 'password'];

    /**
     * The fillable computer access attributes.
     *
     * @var array
     */
    protected $fillable = [
        'computer_id',
        'active_directory',
        'wmi'
    ];

    /**
     * The mutator for the notes attribute.
     *
     * @param string $username
     */
    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = $this->encrypt($username);
    }

    /**
     * The mutator for the password attribute.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = $this->encrypt($password);
    }

    /**
     * The accessor for the username attribute.
     *
     * @param string $username
     *
     * @return null|string
     */
    public function getUsernameAttribute($username)
    {
        if (!is_null($username)) {
            return $this->decrypt($username);
        }

        return null;
    }

    /**
     * The accessor for the password attribute.
     *
     * @param string $password
     *
     * @return null|string
     */
    public function getPasswordAttribute($password)
    {
        if (!is_null($password)) {
            return $this->decrypt($password);
        }

        return null;
    }
}
