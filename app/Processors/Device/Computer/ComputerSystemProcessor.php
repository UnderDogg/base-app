<?php

namespace App\Processors\Device\Computer;

use App\Http\Presenters\Device\ComputerSystemPresenter;
use App\Http\Requests\Device\ComputerSystemRequest;
use App\Jobs\Computer\System\Store;
use App\Jobs\Computer\System\Update;
use App\Models\OperatingSystem;
use App\Processors\Processor;

class ComputerSystemProcessor extends Processor
{
    /**
     * @var OperatingSystem
     */
    protected $system;

    /**
     * @var ComputerSystemPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param OperatingSystem         $system
     * @param ComputerSystemPresenter $presenter
     */
    public function __construct(OperatingSystem $system, ComputerSystemPresenter $presenter)
    {
        $this->system = $system;
        $this->presenter = $presenter;
    }

    /**
     * Displays all operating systems.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $systems = $this->presenter->table($this->system);

        $navbar = $this->presenter->navbar();

        return view('pages.devices.computers.systems.index', compact('systems', 'navbar'));
    }

    /**
     * Displays a form for creating a new operating system.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->system);

        return view('pages.devices.computers.systems.create', compact('form'));
    }

    /**
     * Creates a new operating system.
     *
     * @param ComputerSystemRequest $request
     *
     * @return bool
     */
    public function store(ComputerSystemRequest $request)
    {
        $system = $this->system->newInstance();

        return $this->dispatch(new Store($request, $system));
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
        $system = $this->system->findOrFail($id);

        $form = $this->presenter->form($system);

        return view('pages.devices.computers.systems.create', compact('form'));
    }

    /**
     * Updates the specified operating system.
     *
     * @param ComputerSystemRequest $request
     * @param int|string            $id
     *
     * @return bool
     */
    public function update(ComputerSystemRequest $request, $id)
    {
        $system = $this->system->findOrFail($id);

        return $this->dispatch(new Update($request, $system));
    }

    /**
     * Deletes the specified operating system.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $system = $this->system->findOrFail($id);

        return $system->delete();
    }
}
