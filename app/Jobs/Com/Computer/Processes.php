<?php

namespace App\Jobs\Com\Computer;

use Stevebauman\Wmi\Schemas\Namespaces;

class Processes extends ComputerJob
{
    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $connection = $this->wmi->connect(Namespaces::ROOT_CIMV2);

        $results = $connection
            ->newQuery()
            ->from('Win32_PerfFormattedData_PerfProc_Process')
            ->get();

        $processes = [];

        foreach ($results as $result) {
            $processes[$result->Name] = (int) $result->PercentProcessorTime;
        }

        if (array_key_exists('_Total', $processes)) {
            // We'll overwrite the total percentage since it is usually
            // inaccurate as it includes idle percentage.
            $processes['total'] = array_sum(array_except($processes, ['Idle', '_Total']));
        }

        return $processes;
    }
}
