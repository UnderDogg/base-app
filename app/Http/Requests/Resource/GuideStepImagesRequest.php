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
        $images = $this->file('images');

        if (is_array($images)) {
            $rules = [];

            foreach ($images as $key => $image) {
                // We need to go through each image and create
                // a dot-notated rule for laravel's validation.
                $rules['images.'.$key] = 'image';
            }

            return $rules;
        }

        // Default required rule for redirect.
        return [
            'images' => 'required',
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
