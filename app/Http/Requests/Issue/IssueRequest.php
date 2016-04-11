<?php

namespace App\Http\Requests\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueRequest extends Request
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
     * The issue validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = implode(',', $this->mimes);

        return [
            'title'             => 'required|min:5',
            'occurred_at'       => 'min:18|max:19',
            'description'       => 'required|min:5|max:1000',
            'files.*'           => "mimes:$mimes|max:{$this->size}",
        ];
    }

    /**
     * Allows all users to create issues.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Returns the customized error messages.
     *
     * @return array
     */
    public function messages()
    {
        $mimes = implode(', ', $this->mimes);

        return [
            'files.*.mimes' => "The files field can only contain files of type: $mimes",
            'files.*.max'   => "The files field can only contain files of size: {$this->size}",
        ];
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
        if (!$issue->exists) {
            $issue->user_id = auth()->id();
        }

        $issue->title = $this->input('title', $issue->title);
        $issue->description = $this->input('description', $issue->description);
        $issue->occurred_at = $this->input('occurred_at', $issue->occurred_at);

        if ($issue->save()) {
            // Check if we have any files to upload and attach.
            if (count($this->files) > 0) {
                foreach ($this->file('files') as $file) {
                    if (!is_null($file)) {
                        $issue->uploadFile($file);
                    }
                }
            }

            // Sync the issues labels.
            $labels = $this->input('labels', []);

            if (is_array($labels)) {
                $issue->labels()->sync($labels);
            }

            // Sync the issues users.
            $users = $this->input('users', []);

            if (is_array($users)) {
                $issue->users()->sync($users);
            }

            return true;
        }

        return false;
    }
}
