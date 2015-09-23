<?php

namespace App\Http\Controllers;

use App\Processors\PasswordProcessor;

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

    public function index()
    {
        return $this->processor->index();
    }
}
