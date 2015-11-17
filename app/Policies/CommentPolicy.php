<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy extends Policy
{
    /**
     * Returns true / false if the specified user
     * can edit the specified comment.
     *
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function edit(User $user, Comment $comment)
    {
        return $user->getKey() === $comment->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can update the specified comment.
     *
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->getKey() === $comment->user_id;
    }

    /**
     * Returns true / false if the specified user
     * can delete the specified comment.
     *
     * @param User    $user
     * @param Comment $comment
     *
     * @return bool
     */
    public function destroy(User $user, Comment $comment)
    {
        return $user->getKey() === $comment->user_id;
    }
}
