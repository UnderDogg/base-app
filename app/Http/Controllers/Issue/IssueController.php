<?php

namespace App\Http\Controllers\Issue;

use App\Events\Issue\Created;
use App\Http\Controllers\Controller;
use App\Http\Presenters\Issue\IssuePresenter;
use App\Http\Requests\Issue\IssueCloseRequest;
use App\Http\Requests\Issue\IssueOpenRequest;
use App\Http\Requests\Issue\IssueRequest;
use App\Models\Issue;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class IssueController extends Controller
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
     * @var IssuePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Issue          $issue
     * @param Label          $label
     * @param IssuePresenter $presenter
     */
    public function __construct(Issue $issue, Label $label, IssuePresenter $presenter)
    {
        $this->issue = $issue;
        $this->label = $label;
        $this->presenter = $presenter;
    }

    /**
     * Displays all issues.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $model = $this->issue->open();

        if ($user->cannot('manage.issues')) {
            $model = $model->forUser($user);
        }

        $issues = $this->presenter->table($model);

        $labels = $this->label->all();

        $navbar = $this->presenter->navbar($labels);

        return view('pages.issues.index', compact('issues', 'navbar'));
    }

    /**
     * Displays all closed issues.
     *
     * @return \Illuminate\View\View
     */
    public function closed()
    {
        $user = Auth::user();

        $model = $this->issue->closed();

        if ($user->cannot('manage.issues')) {
            $model = $model->forUser($user);
        }

        $issues = $this->presenter->table($model);

        $labels = $this->label->all();

        $navbar = $this->presenter->navbar($labels);

        return view('pages.issues.index', compact('issues', 'navbar'));
    }

    /**
     * Displays the form for creating an issue.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Is this the users first ticket?
        $first = $this->issue->forUser(Auth::user())->count() === 0;

        $form = $this->presenter->form($this->issue);

        return view('pages.issues.create', compact('form', 'first'));
    }

    /**
     * Processes creating an issue.
     *
     * @param IssueRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueRequest $request)
    {
        if ($request->persist($this->issue)) {
            Event::fire(new Created($this->issue));

            flash()->success('Success!', 'Successfully created ticket.');

            return redirect()->route('issues.index');
        } else {
            flash()->error('Error!', 'There was a problem creating a ticket. Please try again.');

            return redirect()->route('issues.create');
        }
    }

    /**
     * Displays the issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $with = [
            'comments',
            'comments.revisions',
            'comments.files',
            'labels',
            'revisions',
            'files',
        ];

        $issue = $this->issue->with($with)->findOrFail($id);

        $this->authorize('issues.show', [$issue]);

        $resolution = $issue->comments->first(function ($key, $comment) {
            return $comment->resolution;
        });

        $formComment = $this->presenter->formComment($issue);

        $formLabels = $this->presenter->formLabels($issue);

        $formUsers = $this->presenter->formUsers($issue);

        return view('pages.issues.show', compact('issue', 'resolution', 'formComment', 'formLabels', 'formUsers'));
    }

    /**
     * Displays the form for editing the specified issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize('issues.edit', [$issue]);

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

        $this->authorize('issues.edit', [$issue]);

        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully updated ticket.');

            return redirect()->route('issues.show', [$id]);
        }

        flash()->error('Error!', 'There was a problem updating this ticket. Please try again.');

        return redirect()->route('issues.edit', [$id]);
    }

    /**
     * Deletes the specified issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize('issues.destroy', [$issue]);

        if ($issue->delete()) {
            flash()->success('Success!', 'Successfully deleted ticket.');

            return redirect()->route('issues.index');
        }

        flash()->error('Error!', 'There was a problem deleting this ticket. Please try again.');

        return redirect()->route('issues.show', [$id]);

    }

    /**
     * Closes an issue.
     *
     * @param IssueCloseRequest $request
     * @param int|string        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(IssueCloseRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize('issues.close', [$issue]);

        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully closed ticket.');

            return redirect()->back();
        }

        flash()->error('Error!', 'There was a problem closing this ticket. Please try again.');

        return redirect()->back();
    }

    /**
     * Re-Opens an issue.
     *
     * @param IssueOpenRequest $request
     * @param int|string       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function open(IssueOpenRequest $request, $id)
    {
        $issue = $this->issue->findOrFail($id);

        $this->authorize('issues.open', [$issue]);

        if ($request->persist($issue)) {
            flash()->success('Success!', 'Successfully re-opened ticket.');

            return redirect()->back();
        }

        flash()->error('Error!', 'There was a problem re-opening this ticket. Please try again.');

        return redirect()->back();
    }
}
