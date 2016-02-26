<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class RolePermissionRequest extends Request
{
    /**
     * The role permission request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    /**
     * Allows all users to add permissions to roles.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
