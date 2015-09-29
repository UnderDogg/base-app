<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class ComputerRequest extends Request
{
    /**
     * The computer request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'os'    => 'required',
            'type'  => 'required',
        ];
    }

    /**
     * Allows all users to create computers.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
