<?php

namespace App\Http\Requests;

class LoginRequest extends Request
{
    /**
     * The login validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required',
            'password'  => 'required',
        ];
    }

    /**
     * Allows all users to login to the application.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
