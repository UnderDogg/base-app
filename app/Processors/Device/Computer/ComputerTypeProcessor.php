<?php

namespace App\Processors\Device\Computer;

use App\Http\Presenters\Device\ComputerTypePresenter;
use App\Http\Requests\Device\ComputerTypeRequest;
use App\Jobs\Computer\Type\Store;
use App\Jobs\Computer\Type\Update;
use App\Models\ComputerType;
use App\Processors\Processor;

class ComputerTypeProcessor extends Processor
{
    /**
     * @var ComputerType
     */
    protected $type;

    /**
     * @var ComputerTypePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param ComputerType          $type
     * @param ComputerTypePresenter $presenter
     */
    public function __construct(ComputerType $type, ComputerTypePresenter $presenter)
    {
        $this->type = $type;
        $this->presenter = $presenter;
    }

    /**
     * Displays a list of all computer types.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $types = $this->presenter->table($this->type);

        $navbar = $this->presenter->navbar();

        return view('pages.devices.computers.types.index', compact('types', 'navbar'));
    }

    /**
     * Displays the form for creating a new computer type.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->type);

        return view('pages.devices.computers.types.create', compact('form'));
    }

    /**
     * Creates a new computer type.
     *
     * @param ComputerTypeRequest $request
     *
     * @return bool
     */
    public function store(ComputerTypeRequest $request)
    {
        $type = $this->type->newInstance();

        return $this->dispatch(new Store($request, $type));
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
        $type = $this->type->findOrFail($id);

        $form = $this->presenter->form($type);

        return view('pages.devices.computers.types.edit', compact('form'));
    }

    /**
     * Updates the specified computer type.
     *
     * @param ComputerTypeRequest $request
     * @param int|string          $id
     *
     * @return bool
     */
    public function update(ComputerTypeRequest $request, $id)
    {
        $type = $this->type->findOrFail($id);

        return $this->dispatch(new Update($request, $type));
    }

    /**
     * Deletes the specified computer type.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $type = $this->type->findOrFail($id);

        return $type->delete();
    }
}
