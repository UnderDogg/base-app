<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class ComputerPatchRequest extends Request
{
    /**
     * The computer patch request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|min:5|max:40',
            'description'   => 'required|min:5|max:2000',
        ];
    }

    /**
     * Allows all users to create computer patches.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
