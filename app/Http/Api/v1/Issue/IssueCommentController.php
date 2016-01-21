<?php

namespace App\Http\Api\v1\Issue;

use App\Http\Api\v1\Controller;
use App\Models\Issue;

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

        return $issue->comments()->get();
    }
}
