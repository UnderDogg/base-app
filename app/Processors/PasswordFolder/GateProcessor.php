<?php

namespace App\Processors\PasswordFolder;

use App\Http\Requests\PasswordFolder\LockRequest;
use App\Http\Requests\PasswordFolder\UnlockRequest;
use App\Http\Presenters\PasswordFolder\GatePresenter;
use App\Models\PasswordFolder;
use App\Processors\Processor;

class GateProcessor extends Processor
{
    /**
     * @var PasswordFolder
     */
    protected $folder;

    /**
     * @var GatePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param GatePresenter  $presenter
     */
    public function __construct(GatePresenter $presenter)
    {
        $this->folder = auth()->user()->passwordFolder;
        $this->presenter = $presenter;
    }

    /**
     * Displays the password folder PIN gate.
     *
     * @return \Illuminate\View\View
     */
    public function gate()
    {
        $form = $this->presenter->form();

        return view('pages.passwords.gate', compact('form'));
    }

    /**
     * Unlocks the current users password folder.
     *
     * @param UnlockRequest $request
     *
     * @return bool
     */
    public function unlock(UnlockRequest $request)
    {
        return $this->folder->unlock($request);
    }


    /**
     * Locks a users password folder.
     *
     * @param LockRequest $request
     *
     * @return bool
     */
    public function lock(LockRequest $request)
    {
        return $this->folder->lock($request);
    }
}
