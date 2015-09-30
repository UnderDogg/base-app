<?php

namespace App\Processors\Device;

use Adldap\Models\Computer as AdComputer;
use Adldap\Contracts\Adldap;
use App\Jobs\ActiveDirectory\ImportComputer;
use App\Jobs\Computers\Create;
use App\Jobs\Computers\CreateType;
use App\Jobs\Computers\CreateOs;
use App\Http\Presenters\Device\ComputerPresenter;
use App\Http\Requests\Device\ComputerRequest;
use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\OperatingSystem;
use App\Processors\Processor;

class ComputerProcessor extends Processor
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $computers = $this->presenter->table($this->computer);

        $navbar = $this->presenter->navbar();

        return view('pages.devices.computers.index', compact('computers', 'navbar'));
    }

    /**
     * Displays the form to create a computer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->computer);

        return view('pages.devices.computers.create', compact('form'));
    }

    /**
     * Creates a new computer.
     *
     * @param ComputerRequest $request
     *
     * @return bool|Computer
     */
    public function store(ComputerRequest $request)
    {
        // If the user is looking to import the computer from active
        // directory, then we'll try to find the computer by
        // the given name and dispatch the import job.
        if ($request->input('active_directory')) {
            return $this->storeFromActiveDirectory($request);
        } else {
            return $this->storeFromRequest($request);
        }
    }

    /**
     * Creates a new computer from a request.
     *
     * @param ComputerRequest $request
     *
     * @return Computer
     */
    public function storeFromRequest(ComputerRequest $request)
    {
        $os = OperatingSystem::findOrFail($request->input('os'));
        $type = ComputerType::findOrFail($request->input('type'));

        $name = $request->input('name');
        $model = $request->input('model');
        $description = $request->input('description');

        return $this->dispatch(new Create($type->getKey(), $os->getKey(), $name, $description, $model));
    }

    /**
     * Creates a new computer from active directory.
     *
     * @param ComputerRequest $request
     *
     * @return bool|Computer
     */
    public function storeFromActiveDirectory(ComputerRequest $request)
    {
        $computer = $this->adldap->computers()->find($request->input('name'));

        if ($computer instanceof AdComputer) {
            return $this->dispatch(new ImportComputer($computer));
        }

        return false;
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
        $with = [
            'os',
            'type',
            'users',
            'access',
        ];

        $computer = $this->computer->with($with)->findOrFail($id);

        return view('pages.devices.computers.show.details', compact('computer'));
    }
}
