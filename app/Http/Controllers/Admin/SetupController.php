<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SetupRequest;
use App\Processors\Admin\SetupProcessor;

class SetupController extends Controller
{
    /**
     * @var SetupProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param SetupProcessor $processor
     */
    public function __construct(SetupProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the welcome page for setting up administration.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return $this->processor->welcome();
    }

    /**
     * Displays the form for setting up administration.
     *
     * @return \Illuminate\View\View
     */
    public function begin()
    {
        return $this->processor->begin();
    }

    /**
     * Finishes the administration setup.
     *
     * @param SetupRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function finish(SetupRequest $request)
    {
        if ($this->processor->finish($request)) {
            return view('admin.setup.complete');
        } else {
            flash()->error('Error!', 'There was an issue completing setup. Please try again.');

            return redirect()->route('admin.setup.begin');
        }
    }
}
