<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class PatchRequest extends Request
{
    /**
     * The patch request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'computers.*'   => 'exists:computers,id',
            'title'         => 'required|min:5|max:50',
            'description'   => 'required|min:5|max:2000',
        ];
    }

    /**
     * Allows all users to create patches.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
