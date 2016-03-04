<?php

namespace App\Models\Observers;

use App\Models\Comment;

class CommentObserver extends Observer
{
    /**
     * Catches and runs operations when a comment is deleted.
     *
     * @param Comment $comment
     */
    public function deleting(Comment $comment)
    {
        // Make sure the model isn't soft deleted.
        if (!$comment->deleted_at) {
            $files = $comment->files()->get();

            foreach ($files as $file) {
                $file->delete();
            }
        }
    }
}
