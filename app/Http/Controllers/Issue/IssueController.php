<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Issue\IssuePresenter;
use App\Http\Requests\Issue\IssueCloseRequest;
use App\Http\Requests\Issue\IssueOpenRequest;
use App\Http\Requests\Issue\IssueRequest;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Label;
use App\Policies\IssuePolicy;
use Illuminate\Support\Facades\Auth;

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
        $issues = $this->presenter->table($this->issue->open());

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
        $issues = $this->presenter->table($this->issue->closed());

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
        $with = ['comments', 'comments.files', 'labels', 'files'];

        $issue = $this->issue->with($with)->findOrFail($id);

        if (IssuePolicy::show(auth()->user(), $issue)) {
            $resolution = $issue->comments->first(function ($key, Comment $comment) {
                return $comment->resolution;
            });

            $formComment = $this->presenter->formComment($issue);

            $formLabels = $this->presenter->formLabels($issue);

            $formUsers = $this->presenter->formUsers($issue);

            return view('pages.issues.show', compact('issue', 'resolution', 'formComment', 'formLabels', 'formUsers'));
        }

        $this->unauthorized();
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

        if (IssuePolicy::edit(auth()->user(), $issue)) {
            $form = $this->presenter->form($issue);

            return view('pages.issues.edit', compact('form'));
        }

        $this->unauthorized();
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

        if (IssuePolicy::edit(auth()->user(), $issue)) {
            if ($request->persist($issue)) {
                flash()->success('Success!', 'Successfully updated ticket.');

                return redirect()->route('issues.show', [$id]);
            } else {
                flash()->error('Error!', 'There was a problem updating this ticket. Please try again.');

                return redirect()->route('issues.edit', [$id]);
            }
        }

        $this->unauthorized();
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

        if (IssuePolicy::destroy(auth()->user(), $issue)) {
            if ($issue->delete()) {
                flash()->success('Success!', 'Successfully deleted ticket.');

                return redirect()->route('issues.index');
            } else {
                flash()->error('Error!', 'There was a problem deleting this ticket. Please try again.');

                return redirect()->route('issues.show', [$id]);
            }
        }

        $this->unauthorized();
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

        if (IssuePolicy::close(auth()->user(), $issue)) {
            if ($request->persist($issue)) {
                flash()->success('Success!', 'Successfully closed ticket.');

                return redirect()->back();
            } else {
                flash()->error('Error!', 'There was a problem closing this ticket. Please try again.');

                return redirect()->back();
            }
        }

        $this->unauthorized();
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

        if (IssuePolicy::open(auth()->user())) {
            if ($request->persist($issue)) {
                flash()->success('Success!', 'Successfully re-opened ticket.');

                return redirect()->back();
            } else {
                flash()->error('Error!', 'There was a problem re-opening this ticket. Please try again.');

                return redirect()->back();
            }
        }

        $this->unauthorized();
    }
}
