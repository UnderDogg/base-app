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

    /**
     * Creates a new computer type.
     *
     * @param ComputerTypeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ComputerTypeRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created computer type.');

            return redirect()->route('devices.computer-types.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a computer type. Please try again.');

            return redirect()->route('devices.computer-types.create');
        }
    }

    /**
     * Displays the form for editing the specified computer type.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified computer type.
     *
     * @param ComputerTypeRequest $request
     * @param int|string          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ComputerTypeRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated computer type.');

            return redirect()->route('devices.computer-types.index');
        } else {
            flash()->error('Error!', 'There was an issue updating this computer type. Please try again.');

            return redirect()->route('devices.computer-types.edit', [$id]);
        }
    }

    /**
     * Deletes the specified computer type.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted computer type.');

            return redirect()->route('devices.computer-types.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this computer type. Please try again.');

            return redirect()->route('devices.computer-types.index');
        }
    }
}
