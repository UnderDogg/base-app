<?php

namespace App\Http\Requests;

class IssueRequest extends Request
{
    /**
     * The issue validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'title'             => 'required|min:5',
            'occurred_at'       => 'min:18|max:19',
            'description'       => 'required|min:5',
        ];

        $files = $this->files->get('files');

        if (is_array($files)) {
            $rules = [];

            foreach ($files as $key => $file) {
                // We need to go through each image and create
                // a dot-notated rule for laravel's validation.
                $rules['files.'.$key] = 'max:2|mimes:doc,docx,xls,xlsx,png,jpg,bmp';
            }
        }

        return $rules;
    }

    /**
     * Allows all users to create issues.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
