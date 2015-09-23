<?php

namespace App\Models;

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
     * @return string
     */
    public function getPasswordAttribute($password)
    {
        return $this->decrypt($password);
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
        return openssl_encrypt($password, $this->getAlgorithm(), $this->getHash());
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
        return openssl_decrypt($password, $this->getAlgorithm(), $this->getHash());
    }

    /**
     * Returns the hash string for encrypting / decrypting passwords.
     *
     * @return string
     */
    private function getHash()
    {
        return env('APP_KEY');
    }

    /**
     * Returns the hashing algorithm for encrypting / decrypting passwords.
     *
     * @return string
     */
    private function getAlgorithm()
    {
        return config('app.cipher', 'AES-256-CBC');
    }
}
