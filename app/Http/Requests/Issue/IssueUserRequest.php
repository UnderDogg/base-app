<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueUserRequest extends Request
{
    /**
     * Returns the issue user rules.
     *
     * @return array
     */
    public function rules()
    {
        return ['users.*' => 'exists:users,id'];
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

    /**
     * Save the changes.
     *
     * @param Issue $issue
     *
     * @return bool
     */
    public function persist(Issue $issue)
    {
        $issue->users()->sync($this->input('users', []));
        
        return true;
    }
}
