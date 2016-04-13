<?php

namespace App\Http\Requests\Computer;

use App\Http\Requests\Request;

class ComputerSystemRequest extends Request
{
    /**
     * The computer system validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $os = $this->route('computer_systems');

        return [
            'name'          => "required|unique:operating_systems,name,$os",
            'version'       => 'min:2',
            'service_pack'  => 'min:1',
        ];
    }

    /**
     * Allows all users to create computer systems.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
