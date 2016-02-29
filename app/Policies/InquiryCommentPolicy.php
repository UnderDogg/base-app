<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Inquiry;
use App\Models\User;

class InquiryCommentPolicy
{
    /**
     * Returns true / false if the user can create issue comments.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     *
     * @return bool
     */
    public static function create(User $user, Inquiry $inquiry)
    {
        return $user->can('inquiries.comments.create') || $inquiry->user_id === $user->getKey();
    }

    /**
     * Returns true / false if the user can edit issue comments.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     * @param Comment $comment
     *
     * @return bool
     */
    public static function edit(User $user, Inquiry $inquiry, Comment $comment)
    {
        return $user->can('inquiries.comments.edit')
        || ($inquiry->user_id === $user->getKey() && $comment->user_id === $user->getKey());
    }

    /**
     * Returns true / false if the user can delete issue comments.
     *
     * @param User    $user
     * @param Inquiry $inquiry
     * @param Comment $comment
     *
     * @return bool
     */
    public static function destroy(User $user, Inquiry $inquiry, Comment $comment)
    {
        return $user->can('inquiries.comments.destroy')
        || ($inquiry->user_id === $user->getKey() && $comment->user_id === $user->getKey());
    }
}
