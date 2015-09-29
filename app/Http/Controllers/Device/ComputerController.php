<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\Device\ComputerRequest;
use App\Processors\Device\ComputerProcessor;
use App\Http\Controllers\Controller;

class ComputerController extends Controller
{
    /**
     * @var ComputerProcessor
     */
    protected $processor;

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
     * Displays all computers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Show the form for creating a new computer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a computer.
     *
     * @param  ComputerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ComputerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
