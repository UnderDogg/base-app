<?php

namespace App\Http\Controllers\Device\Computer;

use App\Http\Controllers\Controller;
use App\Processors\Device\Computer\ComputerCpuProcessor;
use Illuminate\Contracts\View\View;

class ComputerCpuController extends Controller
{
    /**
     * @var ComputerCpuProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerCpuProcessor $processor
     */
    public function __construct(ComputerCpuProcessor $processor)
    {
        $this->processor = $processor;
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
        $view = $this->processor->index($id);

        if ($view instanceof View) {
            return $view;
        }

        $message = 'There was an issue connecting to this computer via WMI. '.
            'Please make sure this computer is accessible on the network.';

        flash()->setTimer(null)->error('Error!', $message);

        return redirect()->route('devices.computers.show', [$id]);
    }

    /**
     * Returns the specified computers CPU usage in JSON.
     *
     * @param int|string $id
     *
     * @return string
     */
    public function json($id)
    {
        return $this->processor->json($id);
    }
}
