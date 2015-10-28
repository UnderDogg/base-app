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

    /**
     * Displays the form for changing the users
     * PIN for their password folder.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        return $this->processor->change();
    }

    /**
     * Updates the current users password folder PIN.
     *
     * @param ChangePinRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePinRequest $request)
    {
        if ($this->processor->update($request)) {
            flash()->success('Success!', 'Successfully updated PIN.');

            return redirect()->route('passwords.index');
        } else {
            flash()->error('Error!', 'There was an issue changing your PIN. Your currect PIN may have been incorrect. Please try again.');

            return redirect()->back();
        }
    }
}
