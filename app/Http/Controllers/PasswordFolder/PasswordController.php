<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Processors\PasswordProcessor;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * @var PasswordProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PasswordProcessor $processor
     */
    public function __construct(PasswordProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the current users passwords.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }
}
