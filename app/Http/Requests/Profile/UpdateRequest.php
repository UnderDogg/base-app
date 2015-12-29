<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * The profile update validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|min:3',
            'email' => 'required|email',
        ];
    }

    /**
     * Allows all users to update their own profiles.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
