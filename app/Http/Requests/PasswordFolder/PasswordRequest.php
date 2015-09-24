<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;

class PasswordRequest extends Request
{
    /**
     * The password validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required',
            'password'  => 'required',
        ];
    }

    /**
     * Allows all users to create passwords.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
