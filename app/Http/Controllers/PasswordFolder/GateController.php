<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Requests\PasswordFolder\UnlockRequest;
use App\Processors\PasswordFolder\GateProcessor;
use App\Http\Controllers\Controller;

class GateController extends Controller
{
    /**
     * @var GateProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param GateProcessor $processor
     */
    public function __construct(GateProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the password folder PIN gate.
     *
     * @return \Illuminate\View\View
     */
    public function gate()
    {
        return $this->processor->gate();
    }

    /**
     * Unlocks a users password folder.
     *
     * @param UnlockRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function unlock(UnlockRequest $request)
    {
        if ($this->processor->unlock($request)) {
            flash()->success('Success!', 'Successfully entered password folder');

            return redirect()->route('passwords.index');
        } else {
            return redirect()->route('passwords.gate')->withErrors(['pin' => 'Incorrect PIN']);
        }
    }
}
