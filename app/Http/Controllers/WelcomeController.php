<?php

namespace App\Http\Controllers;

use App\Processors\WelcomeProcessor;

class WelcomeController extends Controller
{
    /*
     * @param WelcomeProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param WelcomeProcessor $processor
     */
    public function __construct(WelcomeProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->processor->index();
    }
}
