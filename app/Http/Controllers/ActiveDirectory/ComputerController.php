<?php

namespace App\Http\Controllers\ActiveDirectory;

use Illuminate\Http\Request;
use App\Models\Computer;
use App\Http\Requests\ActiveDirectory\ComputerRequest;
use App\Processors\ActiveDirectory\ComputerProcessor;
use App\Http\Controllers\Controller;

class ComputerController extends Controller
{
    /**
     * Constructor.
     *
     * @param ComputerProcessor $processor
     */
    public function __construct(ComputerProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all active directory computers.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->processor->index($request);
    }

    /**
     * Creates a new computer from active directory.
     *
     * @param ComputerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ComputerRequest $request)
    {
        $computer = $this->processor->store($request);

        if ($computer instanceof Computer) {
            $name = $computer->name;

            flash()->success('Success!', "Successfully added computer $name.");

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was an error adding this computer. Please try again.');

            return redirect()->back();
        }
    }
}
