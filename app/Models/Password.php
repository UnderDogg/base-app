<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;

class Password extends Model
{
    /**
     * The passwords table.
     *
     * @var string
     */
    protected $table = 'passwords';

    /**
     * The hidden password attributes.
     *
     * @var array
     */
    protected $hidden = ['username', 'website', 'password', 'notes'];

    /**
     * The guarded password attributes.
     *
     * @var array
     */
    protected $guarded = ['username', 'website', 'password', 'notes'];

    /**
     * The belongsTo folder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(PasswordFolder::class, 'folder_id');
    }

    /**
     * The mutator for the username attribute.
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
     * The mutator for the notes attribute.
     *
     * @param string $notes
     */
    public function setNotesAttribute($notes)
    {
        $this->attributes['notes'] = $this->encrypt($notes);
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
     * The accessor for the notes attribute.
     *
     * @param string $notes
     *
     * @return null|string
     */
    public function getNotesAttribute($notes)
    {
        if (!is_null($notes)) {
            return $this->decrypt($notes);
        }

        return null;
    }

    /**
     * Encrypts a password.
     *
     * @param string $password
     *
     * @return string
     */
    protected function encrypt($password)
    {
        return Crypt::encrypt($password);
    }

    /**
     * Decrypts a password.
     *
     * @param string $password
     *
     * @return string
     */
    protected function decrypt($password)
    {
        return Crypt::decrypt($password);
    }
}
