<?php

namespace App\Http\Requests\Computer;

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
        $type = $this->route('computer_types');

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
