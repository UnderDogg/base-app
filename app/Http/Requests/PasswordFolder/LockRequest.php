<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;

class LockRequest extends Request
{
    /**
     * The password folder lock validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to lock their password folders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
