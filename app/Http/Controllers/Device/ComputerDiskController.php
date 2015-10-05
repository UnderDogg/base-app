<?php

namespace App\Http\Controllers\Device;

use App\Processors\Device\ComputerDiskProcessor;
use App\Http\Controllers\Controller;

class ComputerDiskController extends Controller
{
    /**
     * @var ComputerDiskProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerDiskProcessor $processor
     */
    public function __construct(ComputerDiskProcessor $processor)
    {
        $this->processor = $processor;
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
        return $this->processor->index($id);
    }
}
