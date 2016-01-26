<?php

namespace App\Http\Api\v1\Issue;

use App\Http\Api\v1\Controller;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Support\Facades\Gate;

class IssueCommentController extends Controller
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * Constructor.
     *
     * @param Issue $issue
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Returns all comments for the specified issue.
     *
     * @param int|string $id
     *
     * @return array
     */
    public function index($id)
    {
        $issue = $this->issue->findOrFail($id);

        return $issue->comments()->get()->map(function (Comment $comment) use ($issue) {
            if (Gate::allows('update', $comment)) {
                $comment->setAttribute('edit_url', route('issues.comments.edit', [$issue->getKey(), $comment->getKey()]));
            }

            if (Gate::allows('destroy', $comment)) {
                $comment->setAttribute('destroy_url', route('issues.comments.destroy', [$issue->getKey(), $comment->getKey()]));
            }

            return $comment;
        });
    }
}
