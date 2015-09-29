<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;
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
     * Returns all access checks.
     *
     * @return string
     */
    public function getChecks()
    {
        $ad = $this->getActiveDirectoryCheck();
        $wmi = $this->getWmiCheck();

        return implode(' ', [$ad, $wmi]);
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by AD.
     *
     * @return string
     */
    public function getActiveDirectoryCheck()
    {
        return $this->createCheck($this->active_directory, 'Active Directory');
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by WMI.
     *
     * @return string
     */
    public function getWmiCheck()
    {
        return $this->createCheck($this->wmi, 'WMI');
    }

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

    /**
     * Creates a check mark or x icon depending if
     * bool is true or false.
     *
     * @param bool|false $bool
     * @param string     $text
     *
     * @return string
     */
    private function createCheck($bool = false, $text = '')
    {
        if ($bool) {
            $check =  HTML::create('i', '', ['class' => 'fa fa-check']);

            return HTML::raw("<span class='label label-success'>$check $text</span>");
        } else {
            $check = HTML::create('i', '', ['class' => 'fa fa-times']);

            return HTML::raw("<span class='label label-danger'>$check $text</span>");
        }
    }
}
