<?php

namespace App\Processors\Device\Computer;

use App\Http\Presenters\Device\ComputerAccessPresenter;
use App\Http\Requests\Device\ComputerAccessRequest;
use App\Jobs\Com\Computer\CheckConnectivity;
use App\Jobs\Computer\CreateAccess;
use App\Models\Computer;
use App\Processors\Processor;

class ComputerAccessProcessor extends Processor
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var ComputerAccessPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer                $computer
     * @param ComputerAccessPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerAccessPresenter $presenter)
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

        return view('pages.devices.computers.show.access', compact('computer', 'form'));
    }

    /**
     * Updates the specified computers settings.
     *
     * @param ComputerAccessRequest $request
     * @param int|string            $id
     *
     * @return bool|\App\Models\ComputerAccess
     */
    public function update(ComputerAccessRequest $request, $id)
    {
        $computer = $this->computer->findOrFail($id);

        $ad = $request->has('active_directory');
        $wmi = $request->has('wmi');

        if (!$request->has('wmi_credentials')) {
            $wmiUsername = $request->input('wmi_username');
            $wmiPassword = $request->input('wmi_password');
        } else {
            $wmiUsername = null;
            $wmiPassword = null;
        }

        $connectivity = new CheckConnectivity($computer);

        $connectivity->setUsername($wmiUsername);
        $connectivity->setPassword($wmiPassword);

        if ($wmi) {
            // If the user specifies a WMI connection, we need to
            // make sure we can connect to it before proceeding.
            $this->dispatch($connectivity);
        }

        return $this->dispatch(new CreateAccess($computer, $ad, $wmi, $wmiUsername, $wmiPassword));
    }
}
