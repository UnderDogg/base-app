<?php

namespace App\Http\Controllers\Device\Computer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\ComputerTypeRequest;
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

    /**
     * Displays the form for creating new computer types.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    public function store(ComputerTypeRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Succesfully created computer type.');
        } else {
            flash()->error('Error!', 'There was an issue creating a computer type. Please try again.');
        }
    }

    public function edit($id)
    {
        return $this->processor->edit($id);
    }
}
