<?php

namespace App\Http\Controllers;

use App\Http\Presenters\LabelPresenter;
use App\Http\Requests\LabelRequest;
use App\Models\Label;
use App\Policies\LabelPolicy;

class LabelController extends Controller
{
    /**
     * @var Label
     */
    protected $label;

    /**
     * @var LabelPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Label          $label
     * @param LabelPresenter $presenter
     */
    public function __construct(Label $label, LabelPresenter $presenter)
    {
        $this->label = $label;
        $this->presenter = $presenter;
    }

    /**
     * Displays all labels.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $labels = $this->presenter->table($this->label);

        $navbar = $this->presenter->navbar();

        return view('pages.labels.index', compact('labels', 'navbar'));
    }

    /**
     * Displays the form for creating a new label.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (LabelPolicy::create(auth()->user())) {
            $form = $this->presenter->form($this->label);

            return view('pages.labels.create', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a new label.
     *
     * @param LabelRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LabelRequest $request)
    {
        if (LabelPolicy::create(auth()->user())) {
            if ($request->persist($this->label)) {
                flash()->success('Success!', 'Successfully created label.');

                return redirect()->route('labels.index');
            }

            flash()->error('Error!', 'There was a problem creating a label. Please try again.');

            return redirect()->route('labels.create');
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified label.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (LabelPolicy::edit(auth()->user())) {
            $label = $this->label->findOrFail($id);

            $form = $this->presenter->form($label);

            return view('pages.labels.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified label.
     *
     * @param LabelRequest $request
     * @param int|string   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LabelRequest $request, $id)
    {
        if (LabelPolicy::edit(auth()->user())) {
            $label = $this->label->findOrFail($id);

            if ($request->persist($label)) {
                flash()->success('Success!', 'Successfully updated label.');

                return redirect()->route('labels.index');
            }

            flash()->error('Error!', 'There was a problem updating this label. Please try again.');

            return redirect()->route('labels.edit', [$id]);
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified label.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (LabelPolicy::destroy(auth()->user())) {
            $label = $this->label->findOrFail($id);

            if ($label->delete()) {
                flash()->success('Success!', 'Successfully deleted label.');

                return redirect()->route('labels.index');
            }

            flash()->error('Error!', 'There was a problem deleting this label. Please try again.');

            return redirect()->route('labels.edit', [$id]);
        }

        $this->unauthorized();
    }
}
