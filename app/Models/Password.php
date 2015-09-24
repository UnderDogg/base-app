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
    protected $hidden = ['password'];

    /**
     * The guarded password attributes.
     *
     * @var array
     */
    protected $guarded = ['password'];

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
     * The mutator for the password attribute.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = $this->encrypt($password);
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
