<?php

namespace App\Http\Requests\Attachment;

use App\Http\Requests\Request;

class ImageRequest extends Request
{
    /**
     * The attachment request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'image',
        ];
    }

    /**
     * Allows only logged in users to upload attachments.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() ? true : false;
    }
}
