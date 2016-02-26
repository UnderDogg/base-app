<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class RoleUserRequest extends Request
{
    /**
     * The role user request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users.*' => 'exists:users,id',
        ];
    }

    /**
     * Allows all users to add users to roles.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
