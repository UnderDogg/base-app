<?php

namespace App\Http\Requests;

class IssueUserRequest extends Request
{
    /**
     * Returns the issue user rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allow all users to add users to issues.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
