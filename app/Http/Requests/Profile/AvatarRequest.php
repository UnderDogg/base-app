<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Request;

class AvatarRequest extends Request
{
    /**
     * The avatar request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'generate'  => '',
            'image'     => '',
        ];
    }

    /**
     * Allows all users to change their own avatars.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
