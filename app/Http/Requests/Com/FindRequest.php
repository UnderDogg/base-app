<?php

namespace App\Http\Requests\Com;

use App\Http\Requests\Request;

class FindRequest extends Request
{
    /**
     * The find request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required|exists:users,forgot_token',
        ];
    }

    /**
     * Allows all users to find accounts using
     * a user ID from active directory.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}