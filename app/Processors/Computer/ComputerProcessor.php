<?php

namespace App\Processors\Computer;

use Adldap\Contracts\AdldapInterface;
use Adldap\Models\Computer as AdComputer;
use App\Http\Presenters\Computer\ComputerPresenter;
use App\Http\Requests\Computer\ComputerRequest;
use App\Jobs\ActiveDirectory\ImportComputer;
use App\Jobs\Computer\Create;
use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\OperatingSystem;
use App\Policies\ComputerPolicy;
use App\Processors\Processor;

class ComputerProcessor extends Processor
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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
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
     * Displays the form to create a computer.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
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
     * Creates a new computer.
     *
     * @param ComputerRequest $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool|Computer
     */
    public function store(ComputerRequest $request)
    {
        if (ComputerPolicy::create(auth()->user())) {
            // If the user is looking to import the computer from active
            // directory, then we'll try to find the computer by
            // the given name and dispatch the import job.
            if ($request->input('active_directory')) {
                return $this->storeFromActiveDirectory($request);
            } else {
                return $this->storeFromRequest($request);
            }
        }

        $this->unauthorized();
    }

    /**
     * Displays the specified computer.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
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
     * Displays the form for the specified computer.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function update(ComputerRequest $request, $id)
    {
        if (ComputerPolicy::edit(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            $os = OperatingSystem::findOrFail($request->input('os'));
            $type = ComputerType::findOrFail($request->input('type'));

            $computer->name = $request->input('name');
            $computer->model = $request->input('model');
            $computer->description = $request->input('description');
            $computer->os_id = $os->getKey();
            $computer->type_id = $type->getKey();

            if ($computer->save()) {
                return $computer;
            }

            return false;
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified computer.
     *
     * @param string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function destroy($id)
    {
        if (ComputerPolicy::destroy(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            return $computer->delete();
        }

        $this->unauthorized();
    }

    /**
     * Creates a new computer from a request.
     *
     * @param ComputerRequest $request
     *
     * @return Computer
     */
    protected function storeFromRequest(ComputerRequest $request)
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
