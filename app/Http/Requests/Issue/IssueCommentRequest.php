<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;

abstract class IssueCommentRequest extends Request
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
     * The issue comment rules.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = implode(',', $this->mimes);

        $size = $this->size;

        return [
            'content'       => 'required',
            'resolution'    => 'integer',
            'files.*'       => "mimes:$mimes|max:$size",
        ];
    }

    /**
     * Allows all users to add comments to issues.
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
