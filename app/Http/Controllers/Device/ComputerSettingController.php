<?php

namespace App\Http\Controllers\Device;

use App\Http\Requests\Device\ComputerSettingRequest;
use App\Processors\Device\ComputerSettingProcessor;
use App\Http\Controllers\Controller;

class ComputerSettingController extends Controller
{
    /**
     * @var ComputerSettingProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ComputerSettingProcessor $processor
     */
    public function __construct(ComputerSettingProcessor $processor)
    {
        $this->processor = $processor;
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
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified computers settings.
     *
     * @param ComputerSettingRequest $request
     * @param int|string             $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ComputerSettingRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated settings.');

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was an issue updating settings. Please try again.');

            return redirect()->back();
        }
    }
}
