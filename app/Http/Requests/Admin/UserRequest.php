<?php

namespace App\Http\Requests\Admin;

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
        $user = $this->route('users');

        $rules = [
            'name'  => 'required|min:2',
            'email' => "required|email|unique:users,email,$user",
        ];

        if ($this->route()->getName() === 'admin.users.update') {
            $rules['password'] = 'confirmed';
        } else {
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        return $rules;
    }

    /**
     * Allows all users to create / edit users.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
