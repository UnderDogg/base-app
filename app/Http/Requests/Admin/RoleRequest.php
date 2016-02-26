<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Role;

class RoleRequest extends Request
{
    /**
     * The role request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $roles = $this->route('roles');

        $role = Role::find($roles);

        $rules = [
            'name'  => "required|unique:roles,name,$roles",
            'label' => 'required',
        ];

        if ($role instanceof Role && $role->isAdministrator()) {
            // If the user is editing an administrator, we need to
            // remove the name validation from the request
            // because they aren't allowed to edit
            // the administrators name.
            unset($rules['name']);
        }

        return $rules;
    }

    /**
     * Allows all users to create / edit roles.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
