<?php

namespace App\Http\Requests\Inquiry;

use App\Http\Requests\Request;
use App\Models\Category;

class InquiryRequest extends Request
{
    /**
     * The inquiry request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'         => 'required|min:5',
            'description'   => 'min:5',
            'manager'       => '',
        ];

        $id = $this->route('categories');

        $category = Category::find($id);

        if ($category instanceof Category && $category->manager === true) {
            $rules['manager'] = 'required|exists:users,id';
        }

        return $rules;
    }

    /**
     * Allow all users to create inquiries.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
