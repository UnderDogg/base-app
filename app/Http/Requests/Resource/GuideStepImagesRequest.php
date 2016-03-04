<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class GuideStepImagesRequest extends Request
{
    /**
     * The guide step images request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'images.*' => 'image',
        ];
    }

    /**
     * Allows all users to add steps by adding bulk images.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
