<?php

namespace App\Processors\Device\Computer;

use App\Http\Presenters\Device\ComputerPatchPresenter;
use App\Http\Requests\Device\ComputerPatchRequest;
use App\Jobs\Computer\Patch\Store;
use App\Jobs\Computer\Patch\Update;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerPatchProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var ComputerPatchPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer               $computer
     * @param ComputerPatchPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerPatchPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    /**
     * Displays all of the specified computers patches.
     *
     * @param int|string $computerId
     *
     * @return \Illuminate\View\View
     */
    public function index($computerId)
    {
        $computer = $this->computer
            ->with(['patches'])
            ->findOrFail($computerId);

        $patches = $this->presenter->table($computer);

        $navbar = $this->presenter->navbar($computer);

        return view('pages.devices.computers.patches.index', compact('computer', 'patches', 'navbar'));
    }

    /**
     * Displays the form for creating a new computer patch.
     *
     * @param int|string $computerId
     *
     * @return \Illuminate\View\View
     */
    public function create($computerId)
    {
        $computer = $this->computer->findOrFail($computerId);

        $patch = $computer->patches()->getRelated();

        $form = $this->presenter->form($computer, $patch);

        return view('pages.devices.computers.patches.create', compact('computer', 'form'));
    }

    /**
     * Creates a new computer patch.
     *
     * @param ComputerPatchRequest $request
     * @param int|string           $computerId
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(ComputerPatchRequest $request, $computerId)
    {
        $computer = $this->computer->findOrFail($computerId);

        return $this->dispatch(new Store($request, $computer));
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
        $computer = $this->computer->findOrFail($computerId);

        $patch = $computer->patches()->findOrFail($patchId);

        $navbar = $this->presenter->navbarShow($computer, $patch);

        return view('pages.devices.computers.patches.show', compact('computer', 'patch', 'navbar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int|string $computerId
     * @param int|string $patchId
     *
     * @return \Illuminate\View\View
     */
    public function edit($computerId, $patchId)
    {
        $computer = $this->computer->findOrFail($computerId);

        $patch = $computer->patches()->findOrFail($patchId);

        $form = $this->presenter->form($computer, $patch);

        return view('pages.devices.computers.patches.edit', compact('computer', 'patch', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ComputerPatchRequest $request
     * @param int|string           $computerId
     * @param int|string           $patchId
     *
     * @return bool
     */
    public function update(ComputerPatchRequest $request, $computerId, $patchId)
    {
        $computer = $this->computer->findOrFail($computerId);

        $patch = $computer->patches()->findOrFail($patchId);

        return $this->dispatch(new Update($request, $patch));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
