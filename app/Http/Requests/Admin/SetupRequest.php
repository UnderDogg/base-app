<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class SetupRequest extends Request
{
    /**
     * The setup request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|min:2',
            'email'                 => 'required|email',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    /**
     * Allows all users to complete setup.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
