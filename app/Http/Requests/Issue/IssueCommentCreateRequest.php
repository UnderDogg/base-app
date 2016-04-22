<?php

namespace App\Http\Requests\Issue;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Support\Facades\Auth;

class IssueCommentCreateRequest extends IssueCommentRequest
{
    /**
     * Save the changes.
     *
     * @param Issue $issue
     *
     * @return bool
     */
    public function persist(Issue $issue)
    {
        $attributes = [
            'content' => $this->input('content'),
            'user_id' => Auth::id(),
        ];

        $resolution = $this->has('resolution');

        // Make sure we only allow one comment resolution
        if ($issue->hasCommentResolution()) {
            $resolution = false;
        }

        // Create the comment.
        $comment = $issue->comments()->create($attributes, compact('resolution'));

        // Check that the comment was created successfully.
        if ($comment instanceof Comment) {
            // Check if we have any files to upload and attach them to the comment.
            if (count($this->files) > 0) {
                foreach ($this->file('files') as $file) {
                    if (!is_null($file)) {
                        $comment->uploadFile($file);
                    }
                }
            }

            return $comment;
        }

        return false;
    }
}
