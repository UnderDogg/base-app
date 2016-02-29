<?php

namespace App\Processors\Issue;

use App\Http\Requests\Issue\IssueUserRequest;
use App\Models\Issue;
use App\Models\User;
use App\Policies\IssuePolicy;
use App\Processors\Processor;

class IssueUserProcessor extends Processor
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Issue $issue
     * @param User  $user
     */
    public function __construct(Issue $issue, User $user)
    {
        $this->issue = $issue;
        $this->user = $user;
    }

    /**
     * Attaches users to the specified issue.
     *
     * @param IssueUserRequest $request
     * @param int|string       $id
     *
     * @return bool
     */
    public function store(IssueUserRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        if (IssuePolicy::addUsers(auth()->user())) {
            if ($request->has('users')) {
                $users = $this->user->find($request->input('users'));

                $issue->users()->sync($users);

                return true;
            }

            $issue->users()->detach();

            return true;
        }

        $this->unauthorized();
    }
}
