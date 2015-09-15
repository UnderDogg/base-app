<?php

namespace App\Processors;

use App\Models\Issue;
use App\Http\Requests\IssueCommentRequest;

class IssueCommentProcessor extends Processor
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
     * Adds a comment to an issue.
     *
     * @param IssueCommentRequest $request
     * @param int|string          $id
     *
     * @return bool|Issue
     */
    public function store(IssueCommentRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        return $issue->createComment($request->input('content'));
    }
}
