<?php

namespace App\Processors\ActiveDirectory;

use Illuminate\Contracts\Auth\Guard;
use App\Processors\Processor;

class SetupQuestionProcessor extends Processor
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * Constructor.
     *
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function index($step = 1)
    {
        
    }
}
