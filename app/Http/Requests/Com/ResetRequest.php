<?php

namespace App\Http\Requests\Com;

use App\Http\Requests\Request;

class ResetRequest extends Request
{
    /**
     * The reset request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:3',
        ];
    }

    /**
     * Allows all users to reset passwords.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
