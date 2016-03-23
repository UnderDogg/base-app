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
            'title'         => 'required|min:5',
            'description'   => 'required|min:5',
        ];
    }

    /**
     * Sanitizes the input.
     *
     * @return array
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['description'] = $this->clean($input['description']);

        $this->replace($input);

        return $this->all();
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
