<?php

namespace App\Jobs\Issue\Comment;

use App\Http\Requests\Issue\IssueCommentRequest;
use App\Jobs\Job;
use App\Models\Comment;
use App\Models\Issue;

class Update extends Job
{
    /**
     * @var IssueCommentRequest
     */
    protected $request;

    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var Comment
     */
    protected $comment;

    /**
     * Constructor.
     *
     * @param IssueCommentRequest $request
     * @param Issue               $issue
     * @param Comment             $comment
     */
    public function __construct(IssueCommentRequest $request, Issue $issue, Comment $comment)
    {
        $this->request = $request;
        $this->issue = $issue;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->comment->content = $this->request->input('content', $this->comment->content);

        $resolution = $this->request->input('resolution', false);

        // Make sure we only allow one comment resolution
        if (!$this->issue->hasCommentResolution() || $this->comment->resolution) {
            $this->issue->comments()->updateExistingPivot($this->comment->id, compact('resolution'));
        }

        if ($this->comment->save()) {
            // Check if we have any files to upload and attach them to the comment.
            if (count($this->request->files) > 0) {
                foreach ($this->request->file('files') as $file) {
                    if (!is_null($file)) {
                        $this->comment->uploadFile($file);
                    }
                }
            }

            return true;
        }

        return false;
    }
}
