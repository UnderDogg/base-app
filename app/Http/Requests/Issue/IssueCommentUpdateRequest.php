<?php

namespace App\Http\Requests\Issue;

use App\Models\Comment;
use App\Models\Issue;

class IssueCommentUpdateRequest extends IssueCommentRequest
{
    /**
     * Save the changes.
     *
     * @param Issue   $issue
     * @param Comment $comment
     *
     * @return bool
     */
    public function persist(Issue $issue, Comment $comment)
    {
        $comment->content = $this->input('content', $comment->content);

        $resolution = $this->input('resolution', false);

        // Make sure we only allow one comment resolution
        if (!$issue->hasCommentResolution() || $comment->resolution) {
            $issue->comments()->updateExistingPivot($comment->id, compact('resolution'));
        }

        if ($comment->save()) {
            // Check if we have any files to upload and attach them to the comment.
            if (count($this->files) > 0) {
                foreach ($this->file('files') as $file) {
                    if (!is_null($file)) {
                        $comment->uploadFile($file);
                    }
                }
            }

            return true;
        }

        return false;
    }
}
