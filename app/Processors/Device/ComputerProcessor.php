<?php

namespace App\Processors\Device;

use App\Jobs\Computers\Create;
use App\Jobs\Computers\CreateType;
use App\Jobs\Computers\CreateOs;
use App\Http\Presenters\Device\ComputerPresenter;
use App\Http\Requests\Device\ComputerRequest;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer          $computer
     * @param ComputerPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    /**
     * Displays all computers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $computers = $this->presenter->table($this->computer);

        $navbar = $this->presenter->navbar();

        return view('pages.devices.computers.index', compact('computers', 'navbar'));
    }

    /**
     * Displays the form to create a computer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->computer);

        return view('pages.devices.computers.create', compact('form'));
    }

    public function store(ComputerRequest $request)
    {

    }
}
