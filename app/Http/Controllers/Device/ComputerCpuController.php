<?php

namespace App\Http\Controllers\Device;

use App\Processors\Device\ComputerCpuProcessor;
use App\Http\Controllers\Controller;

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
        return $this->processor->index($id);
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
