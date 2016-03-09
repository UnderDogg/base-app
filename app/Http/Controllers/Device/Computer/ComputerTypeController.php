<?php

namespace App\Http\Controllers\Device\Computer;

use App\Http\Controllers\Controller;
use App\Processors\Device\Computer\ComputerTypeProcessor;

class ComputerTypeController extends Controller
{
    /**
     * @var ComputerTypeProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerTypeProcessor $processor
     */
    public function __construct(ComputerTypeProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all computer types.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }
}
