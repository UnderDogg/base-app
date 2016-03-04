<?php

namespace App\Processors;

use App\Http\Presenters\LabelPresenter;
use App\Http\Requests\LabelRequest;
use App\Models\Label;
use App\Policies\LabelPolicy;

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
        $labels = $this->presenter->table($this->label);

        $navbar = $this->presenter->navbar();

        return view('pages.labels.index', compact('labels', 'navbar'));
    }

    /**
     * Displays the form for creating a new label.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
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
     * @return bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function store(LabelRequest $request)
    {
        if (LabelPolicy::create(auth()->user())) {
            $label = $this->label->newInstance();

            $label->name = $request->input('name');
            $label->color = $request->input('color');

            return $label->save();
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified label.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
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
     * @return bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function update(LabelRequest $request, $id)
    {
        if (LabelPolicy::edit(auth()->user())) {
            $label = $this->label->findOrFail($id);

            $label->name = $request->input('name', $label->name);
            $label->color = $request->input('color', $label->color);

            return $label->save();
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified label.
     *
     * @param int|string $id
     *
     * @return bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function destroy($id)
    {
        if (LabelPolicy::destroy(auth()->user())) {
            $label = $this->label->findOrFail($id);

            $this->authorize($label);

            return $label->delete();
        }

        $this->unauthorized();
    }
}
