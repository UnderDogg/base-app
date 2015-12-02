<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * The user request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'      => 'required|min:3',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'display_name'  => 'required',
            'description'   => '',
            'profile_path'  => '',
            'logon_script'  => '',
        ];
    }

    /**
     * Allows all users to create or update LDAP users.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
