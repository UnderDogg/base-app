<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy extends Policy
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        //
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
}
