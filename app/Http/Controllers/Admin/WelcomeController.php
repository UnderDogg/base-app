<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Processors\Admin\WelcomeProcessor;

class WelcomeController extends Controller
{
    /**
     * @var WelcomeProcessor
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
     * Displays the admin welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }
}
