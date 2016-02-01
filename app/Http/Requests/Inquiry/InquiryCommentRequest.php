<?php

namespace App\Http\Requests\Inquiry;

use App\Http\Requests\Request;

class InquiryCommentRequest extends Request
{
    /**
     * The inquiry comment validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required',
        ];
    }

    /**
     * Allows all users to create inquiry comments.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
