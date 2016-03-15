<?php

namespace App\Http\Controllers\Device\Computer;

use App\Http\Controllers\Controller;
use App\Processors\Device\Computer\ComputerSystemProcessor;

class ComputerSystemController extends Controller
{
    /**
     * @var ComputerSystemProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerSystemProcessor $processor
     */
    public function __construct(ComputerSystemProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function index()
    {
        return $this->processor->index();
    }

    public function create()
    {
        return $this->processor->create();
    }

    public function store()
    {
        if ($this->processor->store()) {
        } else {
        }
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        if ($this->processor->update($id)) {
        } else {
        }
    }

    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
        } else {
        }
    }
}
