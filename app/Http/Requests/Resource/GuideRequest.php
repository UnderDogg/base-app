<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class GuideRequest extends Request
{
    /**
     * The guide request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|min:5|max:80|unique:guides,title',
            'slug'          => 'required|min:5|max:80|unique:guides,slug',
            'description'   => 'min:5|max:1000',
        ];
    }

    /**
     * The guide request custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.unique' => 'A guide with this title already exists.',
            'slug.unique' => 'A guide with this slug already exists.',
        ];
    }

    /**
     * Only allow logged in users to create / update guides.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }
}
