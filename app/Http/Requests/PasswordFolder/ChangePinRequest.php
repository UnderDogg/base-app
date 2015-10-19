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
            //
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
