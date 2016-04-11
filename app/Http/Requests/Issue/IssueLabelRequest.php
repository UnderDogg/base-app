<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueLabelRequest extends Request
{
    /**
     * Returns the issue label rules.
     *
     * @return array
     */
    public function rules()
    {
        return ['labels.*' => 'exists:labels,id'];
    }

    /**
     * Allow all users to label issues.
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
        $issue->labels()->sync($this->input('labels', []));

        return true;
    }
}
