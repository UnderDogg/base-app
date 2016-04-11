<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueOpenRequest extends Request
{
    /**
     * The issue request open validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to open requests.
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
        if ($issue->isClosed()) {
            $issue->closed = false;
            $issue->closed_at = null;
            $issue->closed_by_user_id = null;

            return $issue->save();
        }

        return false;
    }
}
