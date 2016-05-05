<?php

namespace App\Http\Controllers\Computer;

use Adldap\Contracts\AdldapInterface;
use Adldap\Models\Computer as AdComputer;
use App\Http\Controllers\Controller;
use App\Http\Presenters\Computer\ComputerPresenter;
use App\Http\Requests\Computer\ComputerRequest;
use App\Jobs\ActiveDirectory\ImportComputer;
use App\Jobs\Computer\Store;
use App\Jobs\Computer\Update;
use App\Models\Computer;

class ComputerController extends Controller
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var AdldapInterface
     */
    protected $adldap;

    /**
     * @var ComputerPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer          $computer
     * @param AdldapInterface   $adldap
     * @param ComputerPresenter $presenter
     */
    public function __construct(Computer $computer, AdldapInterface $adldap, ComputerPresenter $presenter)
    {
        $this->computer = $computer;
        $this->adldap = $adldap;
        $this->presenter = $presenter;
    }

    /**
     * Displays all computers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $computers = $this->presenter->table($this->computer);

        $navbar = $this->presenter->navbar();

        return view('pages.computers.index', compact('computers', 'navbar'));
    }

    /**
     * Show the form for creating a new computer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->presenter->form($this->computer);

        return view('pages.computers.create', compact('form'));
    }

    /**
     * Creates a computer.
     *
     * @param ComputerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ComputerRequest $request)
    {
        // If the user is looking to import the computer from active
        // directory, then we'll try to find the computer by
        // the given name and dispatch the import job.
        if ($request->input('active_directory')) {
            $computer = $this->storeFromActiveDirectory($request);
        } else {
            $computer = $this->storeFromRequest($request);
        }

        if ($computer instanceof Computer) {
            flash()->success('Success!', 'Successfully created computer.');

            return redirect()->route('computers.index');
        }

        flash()->error('Error!', 'There was an issue creating a computer. Please try again.');

        return redirect()->route('computers.create');
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
        $computer = $this->computer->with(['os', 'type', 'users'])->findOrFail($id);

        return view('pages.computers.show.details', compact('computer', 'statuses'));
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
        $computer = $this->computer->findOrFail($id);

        $form = $this->presenter->form($computer);

        return view('pages.computers.edit', compact('form', 'computer'));
    }

    /**
     * Updates the specified computer.
     *
     * @param ComputerRequest $request
     * @param int|string      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ComputerRequest $request, $id)
    {
        $computer = $this->computer->findOrFail($id);

        if ($this->dispatch(new Update($request, $computer))) {
            flash()->success('Success!', 'Successfully updated computer.');

            return redirect()->route('computers.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue updating this computer. Please try again.');

        return redirect()->route('computers.edit', [$id]);
    }

    /**
     * Deletes the specified computer.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $computer = $this->computer->findOrFail($id);

        if ($computer->delete()) {
            flash()->success('Success!', 'Successfully deleted computer.');

            return redirect()->route('computers.index');
        }

        flash()->error('Error!', 'There was an issue deleting this computer. Please try again.');

        return redirect()->route('computers.show', [$id]);
    }

    /**
     * Creates a new computer from a request.
     *
     * @param ComputerRequest $request
     *
     * @return Computer|bool
     */
    protected function storeFromRequest(ComputerRequest $request)
    {
        $computer = $this->computer->newInstance();

        return $this->dispatch(new Store($request, $computer));
    }

    /**
     * Creates a new computer from active directory.
     *
     * @param ComputerRequest $request
     *
     * @return Computer|bool
     */
    protected function storeFromActiveDirectory(ComputerRequest $request)
    {
        $computer = $this->adldap
            ->getProvider('default')
            ->search()
            ->computers()
            ->find($request->input('name'));

        if ($computer instanceof AdComputer) {
            return $this->dispatch(new ImportComputer($computer));
        }

        return false;
    }
}
