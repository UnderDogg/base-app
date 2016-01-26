<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Request;

class CategoryRequest extends Request
{
    /**
     * The inquiry request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent'    => 'sometimes|exists:categories,id',
            'name'      => 'required',
        ];
    }

    /**
     * Allows all users to create categories.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
