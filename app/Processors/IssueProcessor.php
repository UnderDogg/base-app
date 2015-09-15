<?php

namespace App\Processors;

use App\Jobs\CloseIssue;
use App\Http\Requests\IssueRequest;
use App\Http\Presenters\IssuePresenter;
use App\Jobs\OpenIssue;
use App\Models\Issue;

class IssueProcessor extends Processor
{
    /**
     * @var Issue
     */
    protected $issue;

    /**
     * @var IssuePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Issue $issue
     * @param IssuePresenter $presenter
     */
    public function __construct(Issue $issue, IssuePresenter $presenter)
    {
        $this->issue = $issue;
        $this->presenter = $presenter;
    }

    /**
     * Returns a table displaying all open issues.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $issues = $this->presenter->table($this->issue);

        $navbar = $this->navbar();

        return view('pages.issues.index', compact('issues', 'navbar'));
    }

    /**
     * Returns a table displaying all closed issues.
     *
     * @return \Illuminate\View\View
     */
    public function closed()
    {
        $issues = $this->presenter->table($this->issue, $closed = true);

        $navbar = $this->navbar();

        return view('pages.issues.index', compact('issues', 'navbar'));
    }

    /**
     * Displays the form for creating a new issue.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->issue);

        return view('pages.issues.create', compact('form'));
    }

    /**
     * Creates a new issue.
     *
     * @param IssueRequest $request
     *
     * @return bool|Issue
     */
    public function store(IssueRequest $request)
    {
        $issue = $this->issue->newInstance();

        $issue->user_id = auth()->user()->getAuthIdentifier();
        $issue->title = $request->input('title');
        $issue->description = $request->input('description');

        if($issue->save()) {
            return $issue;
        }

        return false;
    }

    /**
     * Returns the issue with the specified ID.
     *
     * @param int|string $id
     *
     * @return Issue
     */
    public function show($id)
    {
        $with = ['comments'];

        $issue = $this->issue->with($with)->findOrFail($id);

        $form = $this->presenter->formComment($issue);

        return view('pages.issues.show', compact('issue', 'form'));
    }

    /**
     * Displays the form for editing an issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $issue = $this->issue->findOrFail($id);

        $form = $this->presenter->form($issue);

        return view('pages.issues.edit', compact('form'));
    }

    /**
     * Updates the specified issue.
     *
     * @param IssueRequest $request
     * @param int|string   $id
     *
     * @return bool
     */
    public function update(IssueRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        $issue->title = $request->input('title', $issue->title);
        $issue->description = $request->input('description', $issue->description);

        if($issue->save()) {
            return $issue;
        }

        return false;
    }

    /**
     * Deletes the specified issue.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        return $this->issue->destroy($id);
    }

    /**
     * Closes an issue.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function close($id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->dispatch(new CloseIssue($issue));

        return true;
    }

    /**
     * Opens an issue.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function open($id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->dispatch(new OpenIssue($issue));

        return true;
    }

    /**
     * Returns a new navbar for the issue index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->presenter->fluent([
            'id'    => 'issues',
            'title' => 'Issues',
            'url'   => route('issues.index'),
            'menu'  => view('pages.issues._menu'),
            'attributes' => [
                'class' => 'navbar-default'
            ],
        ]);
    }
}
