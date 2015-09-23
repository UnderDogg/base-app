<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;

class ComputerImportRequest extends Request
{
    /**
     * The computer import validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dn' => 'required',
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
