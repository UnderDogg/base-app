<?php

namespace App\Http\Controllers\ActiveDirectory;

use Illuminate\Http\Request;
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
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->processor->index($request);
    }
}
