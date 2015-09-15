<?php

namespace App\Http\Requests;

class IssueCommentRequest extends Request
{
    /**
     * The issue comment rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required'
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
}
