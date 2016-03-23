<?php

namespace App\Http\Controllers\Device\Computer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\ComputerPatchRequest;
use App\Processors\Device\Computer\ComputerPatchProcessor;

class ComputerPatchController extends Controller
{
    /**
     * @var ComputerPatchProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerPatchProcessor $processor
     */
    public function __construct(ComputerPatchProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int|string $computerId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($computerId)
    {
        return $this->processor->index($computerId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|string $computerId
     *
     * @return \Illuminate\Http\Response
     */
    public function create($computerId)
    {
        return $this->processor->create($computerId);
    }

    /**
     * Creates a new computer.
     *
     * @param ComputerPatchRequest $request
     * @param int|string           $computerId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ComputerPatchRequest $request, $computerId)
    {
        if ($this->processor->store($request, $computerId)) {
            flash()->success('Success!', 'Successfully created patch.');

            return redirect()->route('devices.computers.patches.index', [$computerId]);
        } else {
            flash()->error('Error!', 'There was an issue creating a patch for this computer. Please try again.');

            return redirect()->route('devices.computers.patches.create', [$computerId]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int|string $computerId
     * @param int|string $patchId
     *
     * @return \Illuminate\View\View
     */
    public function show($computerId, $patchId)
    {
        return $this->processor->show($computerId, $patchId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
