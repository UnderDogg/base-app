<?php

namespace App\Http\Controllers\Computer;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Computer\ComputerSystemPresenter;
use App\Http\Requests\Computer\ComputerSystemRequest;
use App\Jobs\Computer\System\Store;
use App\Jobs\Computer\System\Update;
use App\Models\OperatingSystem;

class ComputerSystemController extends Controller
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

        return view('pages.computers.systems.index', compact('systems', 'navbar'));
    }

    /**
     * Displays the form for creating a new operating system.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->system);

        return view('pages.computers.systems.create', compact('form'));
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
        if ($this->dispatch(new Store($request, $this->system))) {
            flash()->success('Success!', 'Successfully created operating system.');

            return redirect()->route('computer-systems.index');
        }

        flash()->error('Error!', 'There was an issue creating an operating system. Please try again.');

        return redirect()->route('computer-systems.create');
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

        return view('pages.computers.systems.create', compact('form'));
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
        $system = $this->system->findOrFail($id);

        if ($this->dispatch(new Update($request, $system))) {
            flash()->success('Success!', 'Successfully updated operating system.');

            return redirect()->route('computer-systems.index');
        }

        flash()->error('Error!', 'There was an issue updating this operating system. Please try again.');

        return redirect()->route('computer-systems.edit', [$id]);
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
        $system = $this->system->findOrFail($id);

        if ($system->delete()) {
            flash()->success('Success!', 'Successfully deleted operating system.');

            return redirect()->route('computer-systems.index');
        }

        flash()->error('Error!', 'There was an issue deleting this operating system. Please try again.');

        return redirect()->route('computer-systems.index');
    }
}
