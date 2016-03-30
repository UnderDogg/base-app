<?php

namespace App\Http\Controllers\Computer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Computer\ComputerSystemRequest;
use App\Processors\Computer\ComputerSystemProcessor;

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

    /**
     * Displays all operating systems.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new operating system.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new operating system.
     *
     * @param ComputerSystemRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ComputerSystemRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created operating system.');

            return redirect()->route('computer-systems.index');
        } else {
            flash()->error('Error!', 'There was an issue creating an operating system. Please try again.');

            return redirect()->route('computer-systems.create');
        }
    }

    /**
     * Displays the form for editing the specified operating system.
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
     * Updates the specified operating system.
     *
     * @param ComputerSystemRequest $request
     * @param int|string            $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ComputerSystemRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated operating system.');

            return redirect()->route('computer-systems.index');
        } else {
            flash()->error('Error!', 'There was an issue updating this operating system. Please try again.');

            return redirect()->route('computer-systems.edit', [$id]);
        }
    }

    /**
     * Deletes the specified operating system.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted operating system.');

            return redirect()->route('computer-systems.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this operating system. Please try again.');

            return redirect()->route('computer-systems.index');
        }
    }
}
