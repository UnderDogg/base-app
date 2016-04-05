<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;

class IssueRequest extends Request
{
    /**
     * The allowed mimes.
     *
     * @var array
     */
    protected $mimes = [
        'doc',
        'docx',
        'xls',
        'xlsx',
        'png',
        'jpg',
        'jpeg',
        'bmp',
        'pdf',
    ];

    /**
     * The allowed file upload size.
     *
     * @var string
     */
    protected $size = '15000';

    /**
     * The issue validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = implode(',', $this->mimes);

        $size = $this->size;

        return [
            'title'             => 'required|min:5',
            'occurred_at'       => 'min:18|max:19',
            'description'       => 'required|min:5',
            'files.*'           => "mimes:$mimes|max:$size",
        ];
    }

    /**
     * Sanitizes the current request of HTML.
     *
     * @return array
     */
    public function sanitize()
    {
        $this->description = $this->clean($this->description);

        return $this->all();
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

    /**
     * Returns the customized error messages.
     *
     * @return array
     */
    public function messages()
    {
        $mimes = implode(', ', $this->mimes);

        $size = $this->size;

        return [
            'files.*.mimes' => "The files field can only contain files of type: $mimes",
            'files.*.max'   => "The files field can only contain files of size: $size",
        ];
    }
}
