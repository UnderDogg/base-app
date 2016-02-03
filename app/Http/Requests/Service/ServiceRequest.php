<?php

namespace App\Http\Requests\Service;

use App\Http\Requests\Request;

class ServiceRequest extends Request
{
    /**
     * The service request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:2',
            'description'   => '',
        ];
    }

    /**
     * Allows all users to create services.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
