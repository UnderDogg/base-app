<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class PatchRequest extends Request
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
     * The patch request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = implode(',', $this->mimes);
        
        return [
            'title'         => 'required|min:5|max:50',
            'description'   => 'required|min:5|max:2000',
            'files.*'       => "mimes:$mimes|max:{$this->size}",
        ];
    }

    /**
     * Allows all users to create patches.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
