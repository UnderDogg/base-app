<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\Device\ComputerRequest;
use App\Models\Computer;
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
        $computer = $this->processor->store($request);

        if ($computer instanceof Computer) {
            flash()->success('Success!', 'Successfully created computer.');

            return redirect()->route('devices.computers.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a computer. Please try again.');

            return redirect()->route('devices.computers.create');
        }
    }

    /**
     * Displays the specified computer.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return $this->processor->show($id);
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

    public function settings($id)
    {

    }
}
