<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Processors\ActiveDirectory\ComputerProcessor;
use App\Http\Controllers\Controller;

class ComputerController extends Controller
{
    /**
     * Constructor.
     *
     * @param ComputerProcessor $processor
     */
    public function __construct(ComputerProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all active directory computers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }
}
