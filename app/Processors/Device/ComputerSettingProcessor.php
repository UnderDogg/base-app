<?php

namespace App\Processors\Device;

use App\Jobs\Computers\CreateAccess;
use App\Http\Requests\Device\ComputerSettingRequest;
use App\Http\Presenters\Device\ComputerSettingPresenter;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerSettingProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer                 $computer
     * @param ComputerSettingPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerSettingPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    /**
     * Displays the page to edit the specified computers settings.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $computer = $this->computer->findOrFail($id);

        $form = $this->presenter->form($computer);

        return view('pages.devices.computers.show.settings', compact('computer', 'form'));
    }

    /**
     * Updates the specified computers settings.
     *
     * @param ComputerSettingRequest $request
     * @param int|string             $id
     *
     * @return bool|\App\Models\ComputerAccess
     */
    public function update(ComputerSettingRequest $request, $id)
    {
        $computer = $this->computer->findOrFail($id);

        $ad = $request->has('active_directory');
        $wmi = $request->has('wmi');

        return $this->dispatch(new CreateAccess($computer->getKey(), $ad, $wmi));
    }
}
