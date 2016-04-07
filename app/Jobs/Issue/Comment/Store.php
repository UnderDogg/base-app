<?php

namespace App\Jobs\Issue\Comment;

use App\Http\Requests\Issue\IssueCommentRequest;
use App\Jobs\Job;
use App\Models\Comment;
use App\Models\Issue;

class Store extends Job
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
     * Constructor.
     *
     * @param IssueCommentRequest $request
     * @param Issue               $issue
     */
    public function __construct(IssueCommentRequest $request, Issue $issue)
    {
        $this->request = $request;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        $attributes = [
            'content' => $this->request->input('content'),
            'user_id' => auth()->user()->id,
        ];

        $resolution = $this->request->has('resolution');

        // Make sure we only allow one comment resolution
        if ($this->issue->hasCommentResolution()) {
            $resolution = false;
        }

        // Create the comment.
        $comment = $this->issue->comments()->create($attributes, compact('resolution'));

        // Check that the comment was created successfully.
        if ($comment instanceof Comment) {
            // Check if we have any files to upload and attach them to the comment.
            if (count($this->request->files) > 0) {
                foreach ($this->request->file('files') as $file) {
                    if (!is_null($file)) {
                        $comment->uploadFile($file);
                    }
                }
            }

            return $comment;
        }

        return false;
    }
}
