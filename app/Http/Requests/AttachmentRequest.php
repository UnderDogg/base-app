<?php

namespace App\Http\Requests;

use App\Models\Upload;

class AttachmentRequest extends Request
{
    /**
     * The attachment requests validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
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

    /**
     * Save the changes.
     *
     * @param Upload $upload
     *
     * @return bool
     */
    public function persist(Upload $upload)
    {
        $upload->name = $this->input('name', $upload->name);

        return $upload->save();
    }
}
