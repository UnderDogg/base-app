<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;

class ComputerRequest extends Request
{
    /**
     * The computer validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'required' => 'dn',
        ];
    }

    /**
     * Allows all users to add AD computers.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
