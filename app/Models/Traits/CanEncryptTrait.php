<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Crypt;

trait CanEncryptTrait
{
    /**
     * Encrypts a string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function encrypt($string)
    {
        return Crypt::encrypt($string);
    }

    /**
     * Decrypts a string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function decrypt($string)
    {
        return Crypt::decrypt($string);
    }
}
