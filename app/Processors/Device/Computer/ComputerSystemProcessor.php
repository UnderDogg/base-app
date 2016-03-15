<?php

namespace App\Processors\Device\Computer;

use App\Http\Presenters\Device\ComputerSystemPresenter;
use App\Models\OperatingSystem;
use App\Processors\Processor;

class ComputerSystemProcessor extends Processor
{
    /**
     * @var OperatingSystem
     */
    protected $os;

    /**
     * @var ComputerSystemPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param OperatingSystem         $os
     * @param ComputerSystemPresenter $presenter
     */
    public function __construct(OperatingSystem $os, ComputerSystemPresenter $presenter)
    {
        $this->os = $os;
        $this->presenter = $presenter;
    }

    /**
     * Displays all operating systems.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $systems = $this->presenter->table($this->os);

        $navbar = $this->presenter->navbar();

        return view('pages.devices.computers.systems.index', compact('systems', 'navbar'));
    }

    /**
     * Displays a form for creating a new operating system.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->os);

        return view('pages.devices.computers.systems.create', compact('form'));
    }

    public function store()
    {
        //
    }

    public function edit($id)
    {
        $os = $this->os->findOrFail($id);

        $form = $this->presenter->form($os);

        return view('pages.devices.computers.systems.create', compact('form'));
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
