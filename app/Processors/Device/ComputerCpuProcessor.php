<?php

namespace App\Processors\Device;

use App\Jobs\Com\Computer\Processes;
use App\Models\Computer;
use App\Processors\Processor;
use Khill\Lavacharts\Configs\DataTable;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class ComputerCpuProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer $computer
     */
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
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

        $dataTable = $this->cpuDataTable($computer);

        $cpu = $this->cpuChart($dataTable);

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

        return $this->cpuDataTable($computer)->toJson();
    }

    /**
     * Creates a new DataTable for the specified Computer CPU usage.
     *
     * @param Computer $computer
     *
     * @throws \Khill\Lavacharts\Exceptions\InvalidCellCount
     * @throws \Khill\Lavacharts\Exceptions\InvalidRowDefinition
     *
     * @return DataTable
     */
    protected function cpuDataTable(Computer $computer)
    {
        $processes = $this->dispatch(new Processes($computer));

        /* @var \Khill\Lavacharts\Configs\DataTable $cpu */
        $cpu = Lava::DataTable();

        $cpu
            ->addStringColumn('Type')
            ->addNumberColumn('Value')
            ->addRow(['CPU', $processes['total']]);

        return $cpu;
    }

    /**
     * Returns a new chart for the specified computers CPU usage.
     *
     * @throws \Khill\Lavacharts\Exceptions\InvalidCellCount
     * @throws \Khill\Lavacharts\Exceptions\InvalidRowDefinition
     *
     * @return \Khill\Lavacharts\Charts\GaugeChart
     */
    protected function cpuChart(DataTable $table)
    {
        /* @var \Khill\Lavacharts\Charts\GaugeChart */
        $chart = Lava::GaugeChart('cpu');

        $chart->setOptions([
            'datatable'  => $table,
            'width'      => 400,
            'greenFrom'  => 0,
            'greenTo'    => 69,
            'yellowFrom' => 70,
            'yellowTo'   => 89,
            'redFrom'    => 90,
            'redTo'      => 100,
            'majorTicks' => [
                'Safe',
                'Critical',
            ],
        ]);

        return $chart;
    }
}
