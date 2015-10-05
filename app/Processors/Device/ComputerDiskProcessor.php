<?php

namespace App\Processors\Device;

use App\Http\Presenters\Device\ComputerDiskPresenter;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerDiskProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var ComputerDiskPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer              $computer
     * @param ComputerDiskPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerDiskPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified computers hard disks.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $computer = $this->computer->findOrFail($id);

        return view('pages.devices.computers.show.disks', compact('computer'));
    }
}
