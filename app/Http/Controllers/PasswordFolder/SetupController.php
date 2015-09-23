<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Requests\PasswordFolder\SetupRequest;
use App\Processors\PasswordFolder\SetupProcessor;
use App\Http\Controllers\Controller;

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

    public function start()
    {
        //
    }

    public function finish(SetupRequest $request)
    {
        //
    }

    public function invalid()
    {
        //
    }
}
