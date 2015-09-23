<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;

class UserImportRequest extends Request
{
    /**
     * The user import validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dn' => 'required',
        ];
    }

    /**
     * Allows all users to import users from active directory.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
