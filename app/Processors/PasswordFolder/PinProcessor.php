<?php

namespace App\Processors\PasswordFolder;

use App\Http\Presenters\PasswordFolder\PinPresenter;
use App\Http\Requests\PasswordFolder\ChangePinRequest;
use App\Models\PasswordFolder;
use App\Processors\Processor;

class PinProcessor extends Processor
{
    /**
     * @var PasswordFolder
     */
    protected $folder;

    /**
     * @var PinPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param PasswordFolder $folder
     * @param PinPresenter   $presenter
     */
    public function __construct(PasswordFolder $folder, PinPresenter $presenter)
    {
        $this->folder = $folder;
        $this->presenter = $presenter;
    }

    /**
     * Displays the form to change the users password folder PIN.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        return view('pages.passwords.change-pin');
    }

    public function update(ChangePinRequest $request)
    {

    }
}
