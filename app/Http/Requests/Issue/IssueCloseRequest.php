<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueCloseRequest extends Request
{
    /**
     * The issue close request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Allows all users to close.
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
        if ($issue->isOpen()) {
            $issue->closed = true;
            $issue->closed_at = $issue->freshTimestamp();
            $issue->closed_by_user_id = auth()->id();

            return $issue->save();
        }

        return false;
    }
}
