<?php

namespace App\Http\Requests;

class IssueLabelRequest extends Request
{
    /**
     * Returns the issue label rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
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
}
