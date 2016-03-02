<?php

namespace App\Jobs\Issue;

use App\Http\Requests\Issue\IssueRequest;
use App\Jobs\Job;
use App\Models\Issue;

class Store extends Job
{
    /**
     * @var IssueRequest
     */
    protected $request;

    /**
     * @var Issue
     */
    protected $issue;

    /**
     * Constructor.
     *
     * @param IssueRequest $request
     * @param Issue        $issue
     */
    public function __construct(IssueRequest $request, Issue $issue)
    {
        $this->request = $request;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->issue->user_id = auth()->id();
        $this->issue->title = $this->request->input('title');
        $this->issue->description = $this->request->input('description');
        $this->issue->occurred_at = $this->request->input('occurred_at');

        if ($this->issue->save()) {
            // Check if we have any files to upload and attach.
            if (count($this->request->files) > 0) {
                foreach ($this->request->file('files') as $file) {
                    if (!is_null($file)) {
                        $this->issue->uploadFile($file);
                    }
                }
            }

            // Sync the issues labels.
            $labels = $this->request->input('labels', []);

            if (is_array($labels)) {
                $this->issue->labels()->sync($labels);
            }

            // Sync the issues users.
            $users = $this->request->input('users', []);

            if (is_array($users)) {
                $this->issue->users()->sync($users);
            }



            return true;
        }

        return false;
    }
}
