<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class ComputerTypeRequest extends Request
{
    /**
     * The computer type validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->route('computer-types');

        return [
            'name' => "required|unique:computer_types,name,$type",
        ];
    }

    /**
     * Allow all users to create computer types.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
