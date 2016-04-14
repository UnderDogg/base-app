<?php

namespace App\Http\Requests\Computer;

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
        $computer = $this->route('computers');

        return [
            'name'  => "required|unique:computers,name,$computer",
            'os'    => 'required_without:active_directory',
            'type'  => 'required_without:active_directory',
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
