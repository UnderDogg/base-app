<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;

class SetupRequest extends Request
{
    /**
     * The password setup validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pin'               => 'required|confirmed|min:4',
            'pin_confirmation'  => 'required|min:4',
        ];
    }

    /**
     * Allows all users to setup their own password folders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
