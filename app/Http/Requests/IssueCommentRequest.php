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
     * Sanitizes the comment content.
     *
     * @return array
     */
    public function sanitize()
    {
        $input = $this->all();

        $input['content'] = $this->clean($input['content']);

        $this->replace($input);

        return $this->all();
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
