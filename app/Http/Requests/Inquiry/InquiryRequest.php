<?php

namespace App\Http\Requests\Inquiry;

use App\Models\Category;
use App\Http\Requests\Request;

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
            'category'      => 'required|integer|exists:categories,id,belongs_to,inquiries',
            'title'         => 'required|min:5',
            'description'   => 'min:5',
            'manager'       => '',
        ];

        $id = $this->request->get('category');

        $category = Category::find($id);

        if ($category instanceof Category
            && is_array($category->options)
            && array_key_exists('manager', $category->options)
        ) {
            if ($category->options['manager'] === true) {
                $rules['manager'] = 'required|exists:users,id';
            }
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
