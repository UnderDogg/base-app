<?php

namespace App\Http\Controllers\Computer;

use Adldap\Contracts\Adldap;
use Adldap\Models\Computer as AdComputer;
use App\Http\Presenters\Computer\ComputerPresenter;
use App\Http\Requests\Computer\ComputerRequest;
use App\Jobs\ActiveDirectory\ImportComputer;
use App\Jobs\Computer\Create;
use App\Jobs\Computer\Store;
use App\Jobs\Computer\Update;
use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\OperatingSystem;
use App\Policies\ComputerPolicy;
use App\Http\Controllers\Controller;

class ComputerController extends Controller
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var Adldap
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
     * @param Adldap            $adldap
     * @param ComputerPresenter $presenter
     */
    public function __construct(Computer $computer, Adldap $adldap, ComputerPresenter $presenter)
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
        if (ComputerPolicy::index(auth()->user())) {
            $computers = $this->presenter->table($this->computer);

            $navbar = $this->presenter->navbar();

            return view('pages.computers.index', compact('computers', 'navbar'));
        }

        $this->unauthorized();
    }

    /**
     * Show the form for creating a new computer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (ComputerPolicy::create(auth()->user())) {
            $form = $this->presenter->form($this->computer);

            return view('pages.computers.create', compact('form'));
        }

        $this->unauthorized();
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
        if (ComputerPolicy::create(auth()->user())) {
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
            } else {
                flash()->error('Error!', 'There was an issue creating a computer. Please try again.');

                return redirect()->route('computers.create');
            }
        }

        $this->unauthorized();
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
        if (ComputerPolicy::show(auth()->user())) {
            $with = [
                'os',
                'type',
                'users',
                'access',
            ];

            $computer = $this->computer->with($with)->findOrFail($id);

            return view('pages.computers.show.details', compact('computer'));
        }

        $this->unauthorized();
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
        if (ComputerPolicy::edit(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            $form = $this->presenter->form($computer);

            return view('pages.computers.edit', compact('form', 'computer'));
        }

        $this->unauthorized();
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
        if (ComputerPolicy::edit(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            if ($this->dispatch(new Update($request, $computer))) {
                flash()->success('Success!', 'Successfully updated computer.');

                return redirect()->route('computers.show', [$id]);
            }

            flash()->error('Error!', 'There was an issue updating this computer. Please try again.');

            return redirect()->route('computers.edit', [$id]);
        }

        $this->unauthorized();
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
        if (ComputerPolicy::destroy(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            if ($computer->delete()) {
                flash()->success('Success!', 'Successfully deleted computer.');

                return redirect()->route('computers.index');
            }

            flash()->error('Error!', 'There was an issue deleting this computer. Please try again.');

            return redirect()->route('computers.show', [$id]);
        }

        $this->unauthorized();
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
        $computer = $this->adldap->computers()->find($request->input('name'));

        if ($computer instanceof AdComputer) {
            return $this->dispatch(new ImportComputer($computer));
        }

        return false;
    }
}
