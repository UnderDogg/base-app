<?php

namespace App\Processors\Device;

use App\Http\Presenters\Device\ComputerPresenter;
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
}
