<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UserPermissionRequest extends Request
{
    /**
     * The user permission request validation rules.
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
     * Allows all users to add permissions to users.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
