<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;

class Password extends Model
{
    use HasUserTrait;

    /**
     * The passwords table.
     *
     * @var string
     */
    protected $table = 'passwords';

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
