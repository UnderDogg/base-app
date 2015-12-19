<?php

namespace App\Http\Controllers;

use App\Processors\ProfileProcessor;

class ProfileController extends Controller
{
    /**
     * @var ProfileProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ProfileProcessor $processor
     */
    public function __construct(ProfileProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the current users profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return $this->processor->show();
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }
}
