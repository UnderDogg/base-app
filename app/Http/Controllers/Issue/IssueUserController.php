<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\IssueUserRequest;
use App\Models\Issue;
use App\Models\User;

class IssueUserController extends Controller
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
     * Updates the specified issue labels.
     *
     * @param IssueUserRequest $request
     * @param int|string       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueUserRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize($issue);
        
        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully updated users for this issue.');

            return redirect()->route('issues.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue adding users to this issue. Please try again.');

        return redirect()->route('issues.show', [$id]);
    }
}
