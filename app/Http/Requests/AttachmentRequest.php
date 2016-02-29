<?php

namespace App\Http\Requests;

class AttachmentRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|',
        ];
    }

    /**
     * Allows all users to modify attachments.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
