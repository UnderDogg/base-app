<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class PatchRequest extends Request
{
    /**
     * The allowed file upload size.
     *
     * @var string
     */
    protected $size = '150000';

    /**
     * The patch request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|min:5|max:50',
            'description'   => 'required|min:5|max:2000',
            'files.*'       => "max:{$this->size}",
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
