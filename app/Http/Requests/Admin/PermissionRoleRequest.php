<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PermissionRoleRequest extends Request
{
    /**
     * The permission role request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roles.*' => 'exists:roles,id',
        ];
    }

    /**
     * Allows all users to add roles to permissions.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
