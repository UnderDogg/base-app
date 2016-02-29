<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;

class IssueCommentPolicy
{
    /**
     * Returns true / false if the user can create issue comments.
     *
     * @param User  $user
     * @param Issue $issue
     *
     * @return bool
     */
    public static function create(User $user, Issue $issue)
    {
        return $user->can('issues.comments.create') || $issue->user_id === $user->getKey();
    }

    /**
     * Returns true / false if the user can edit issue comments.
     *
     * @param User    $user
     * @param Issue   $issue
     * @param Comment $comment
     *
     * @return bool
     */
    public static function edit(User $user, Issue $issue, Comment $comment)
    {
        return $user->can('issues.comments.edit')
            || ($issue->user_id === $user->getKey() && $comment->user_id === $user->getKey());
    }

    /**
     * Returns true / false if the user can delete issue comments.
     *
     * @param User    $user
     * @param Issue   $issue
     * @param Comment $comment
     *
     * @return bool
     */
    public static function destroy(User $user, Issue $issue, Comment $comment)
    {
        return $user->can('issues.comments.destroy')
        || ($issue->user_id === $user->getKey() && $comment->user_id === $user->getKey());
    }
}
