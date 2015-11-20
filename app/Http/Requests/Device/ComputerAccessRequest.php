<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class ComputerAccessRequest extends Request
{
    /**
     * The computer access validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to update the computers access.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
