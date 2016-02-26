<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Returns true / false if the specified user
     * can edit the specified comment.
     *
     * @return bool
     */
    public function store(User $user)
    {
        return $user->can('comments.create');
    }

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
        return $user->can('comments.edit') && $user->getKey() === $comment->user_id;
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
