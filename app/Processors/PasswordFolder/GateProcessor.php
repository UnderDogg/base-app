<?php

namespace App\Processors\PasswordFolder;

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
     * @param PasswordFolder $folder
     * @param GatePresenter  $presenter
     */
    public function __construct(PasswordFolder $folder, GatePresenter $presenter)
    {
        $this->folder = $folder;
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
        $folder = $this->folder->where('user_id', auth()->user()->getKey())->first();

        if ($folder instanceof PasswordFolder) {
            return $folder->unlock($request);
        }

        return false;
    }
}
