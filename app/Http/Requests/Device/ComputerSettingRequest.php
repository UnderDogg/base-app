<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class ComputerSettingRequest extends Request
{
    /**
     * The computer setting validation rules.
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to update computer settings.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
