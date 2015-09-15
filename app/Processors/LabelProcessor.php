<?php

namespace App\Processors;

use App\Http\Presenters\LabelPresenter;
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
        $labels = $this->presenter->table($this->label);

        return view('pages.labels.index', compact('labels'));
    }
}
