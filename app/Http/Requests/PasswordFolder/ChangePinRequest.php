<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;

class ChangePinRequest extends Request
{
    /**
     * The change pin validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pin'       => 'required|min:4',
            'new_pin'   => 'required|confirmed|min:4',
        ];
    }

    /**
     * Allow all users to change their password folder pin.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
