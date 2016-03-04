<?php

namespace App\Models\Observers;

use App\Models\Issue;

class IssueObserver extends Observer
{
    /**
     * Operations to run upon deleting an issue.
     *
     * @param Issue $issue
     */
    public function deleting(Issue $issue)
    {
        // Make sure the model isn't soft deleted.
        if (!$issue->deleted_at) {
            // Detach the issue labels.
            $issue->labels()->detach();

            // Retrieve the comments attached to the current issue.
            $comments = $issue->comments()->get();

            // Detach the comments issue comments.
            $issue->comments()->detach();

            // Delete all of the comments.
            foreach ($comments as $comment) {
                $comment->delete();
            }

            // Delete the issue attachments.
            $files = $issue->files()->get();

            foreach ($files as $file) {
                $file->delete();
            }
        }
    }
}
