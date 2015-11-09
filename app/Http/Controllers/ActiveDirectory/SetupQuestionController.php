<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Processors\ActiveDirectory\SetupQuestionProcessor;
use App\Http\Controllers\Controller;

class SetupQuestionController extends Controller
{
    /**
     * Constructor.
     *
     * @param SetupQuestionProcessor $processor
     */
    public function __construct(SetupQuestionProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function index($step = 1)
    {
        return $this->processor->index($step);
    }
}
