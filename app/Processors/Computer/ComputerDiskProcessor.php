<?php

namespace App\Processors\Computer;

use App\Http\Presenters\Computer\ComputerDiskPresenter;
use App\Jobs\Com\Computer\ScanDisks;
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
        $computer = $this->computer->with(['disks', 'disks.records'])->findOrFail($id);

        $disks = $this->presenter->disks($computer);

        $diskGraph = $this->presenter->diskGraph($computer);

        return view('pages.computers.show.disks', compact('computer', 'disks', 'diskGraph'));
    }

    /**
     * Scans the specified computer for it's hard disks.
     *
     * @param int|string $id
     *
     * @return bool|array
     */
    public function synchronize($id)
    {
        $computer = $this->computer->findOrFail($id);

        return $this->dispatch(new ScanDisks($computer));
    }
}
