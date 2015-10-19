<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordFolder\ChangePinRequest;
use App\Processors\PasswordFolder\PinProcessor;

class PinController extends Controller
{
    /**
     * @var PinProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PinProcessor $processor
     */
    public function __construct(PinProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function change()
    {
        return $this->processor->change();
    }

    public function update(ChangePinRequest $request)
    {
        if ($this->processor->update($request)) {

        } else {

        }
    }
}
