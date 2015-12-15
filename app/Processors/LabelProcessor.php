<?php

namespace App\Processors;

use App\Http\Presenters\LabelPresenter;
use App\Http\Requests\LabelRequest;
use App\Models\Label;

class LabelProcessor extends Processor
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
     * Displays the list of all labels.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize($this->label);

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
        $this->authorize($this->label);

        $form = $this->presenter->form($this->label);

        return view('pages.labels.create', compact('form'));
    }

    /**
     * Creates a new label.
     *
     * @param LabelRequest $request
     *
     * @return bool
     */
    public function store(LabelRequest $request)
    {
        $this->authorize($this->label);

        $label = $this->label->newInstance();

        $label->name = $request->input('name');
        $label->color = $request->input('color');

        return $label->save();
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
        $label = $this->label->findOrFail($id);

        $this->authorize($label);

        $form = $this->presenter->form($label);

        return view('pages.labels.edit', compact('form'));
    }

    /**
     * Updates the specified label.
     *
     * @param LabelRequest $request
     * @param int|string   $id
     *
     * @return bool
     */
    public function update(LabelRequest $request, $id)
    {
        $label = $this->label->findOrFail($id);

        $this->authorize($label);

        $label->name = $request->input('name', $label->name);
        $label->color = $request->input('color', $label->color);

        return $label->save();
    }

    /**
     * Deletes the specified label.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $label = $this->label->findOrFail($id);

        $this->authorize($label);

        return $label->delete();
    }
}
