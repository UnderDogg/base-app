<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;

class UnlockRequest extends Request
{
    /**
     * The password unlock validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pin' => 'required|min:4',
        ];
    }

    /**
     * Allow all users to unlock their password folders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
