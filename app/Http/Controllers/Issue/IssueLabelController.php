<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\IssueLabelRequest;
use App\Models\Issue;
use App\Models\Label;

class IssueLabelController extends Controller
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var Label
     */
    protected $label;

    /**
     * Constructor.
     *
     * @param Issue $issue
     * @param Label $label
     */
    public function __construct(Issue $issue, Label $label)
    {
        $this->issue = $issue;
        $this->label = $label;
    }

    /**
     * Updates the specified issue labels.
     *
     * @param IssueLabelRequest $request
     * @param int|string        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueLabelRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully updated labels for this issue.');

            return redirect()->route('issues.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue adding labels to this issue. Please try again.');

        return redirect()->route('issues.show', [$id]);
    }
}
