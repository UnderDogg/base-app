<?php

namespace App\Processors\Device;

use App\Http\Presenters\Device\ComputerCpuPresenter;
use App\Jobs\Com\Computer\Processes;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerCpuProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var ComputerCpuPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer             $computer
     * @param ComputerCpuPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerCpuPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified computers CPU usage.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $computer = $this->computer->findOrFail($id);

        $processes = $this->dispatch(new Processes($computer));

        $cpu = $this->presenter->cpu($processes);

        return view('pages.devices.computers.show.cpu', compact('computer', 'cpu'));
    }

    /**
     * Returns the CPU data table in json.
     *
     * @param int|string $id
     *
     * @return string
     */
    public function json($id)
    {
        $computer = $this->computer->findOrFail($id);

        $processes = $this->dispatch(new Processes($computer));

        return $this->presenter->cpuDataTable($processes)->toJson();
    }
}
