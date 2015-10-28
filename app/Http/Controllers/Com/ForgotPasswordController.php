<?php

namespace App\Http\Controllers\Com;

use App\Http\Requests\Com\ResetRequest;
use App\Processors\Com\ForgotPasswordProcessor;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * @var ForgotPasswordProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ForgotPasswordProcessor $processor
     */
    public function __construct(ForgotPasswordProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the form to reset a users password.
     *
     * @return \Illuminate\View\View
     */
    public function reset()
    {
        return $this->processor->reset();
    }

    public function questions(ResetRequest $request)
    {
        return $this->processor->questions($request);
    }
}
