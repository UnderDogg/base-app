<?php

namespace App\Http\Requests;

class PasswordUnlockRequest extends Request
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
