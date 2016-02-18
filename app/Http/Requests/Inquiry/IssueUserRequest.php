<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;

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
