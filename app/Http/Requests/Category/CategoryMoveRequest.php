<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Request;

class CategoryMoveRequest extends Request
{
    /**
     * The category move validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'required|integer|exists:categories',
        ];
    }

    /**
     * Allows all users to move categories.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
