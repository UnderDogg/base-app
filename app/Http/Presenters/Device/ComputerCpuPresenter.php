<?php

namespace App\Http\Presenters\Device;

use App\Http\Presenters\Presenter;
use Khill\Lavacharts\Configs\DataTable;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class ComputerCpuPresenter extends Presenter
{
    /**
     * Returns a new GaugeChart of the specified processes.
     *
     * @param array $processes
     *
     * @return \Khill\Lavacharts\Charts\GaugeChart
     */
    public function cpu(array $processes = [])
    {
        $dataTable = $this->cpuDataTable($processes);

        return $this->cpuChart($dataTable);
    }

    /**
     * Creates a new DataTable for the specified Computer CPU usage.
     *
     * @param array $processes
     *
     * @throws \Khill\Lavacharts\Exceptions\InvalidCellCount
     * @throws \Khill\Lavacharts\Exceptions\InvalidRowDefinition
     *
     * @return DataTable
     */
    public function cpuDataTable(array $processes = [])
    {
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
    public function cpuChart(DataTable $table)
    {
        /* @var \Khill\Lavacharts\Charts\GaugeChart */
        $chart = Lava::GaugeChart('cpu');

        $chart->datatable = $table;

        $chart->setOptions([
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
