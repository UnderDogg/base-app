<?php

namespace App\Http\Requests\Inquiry;

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
        return [
            'category'      => 'required|integer|exists:categories,id,belongs_to,inquiries',
            'title'         => 'required|min:5',
            'description'   => 'min:5',
        ];
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
