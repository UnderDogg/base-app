<?php

namespace App\Processors;

use App\Http\Presenters\ProfilePresenter;
use Illuminate\Contracts\Auth\Guard;

class ProfileProcessor extends Processor
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var ProfilePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guard            $guard
     * @param ProfilePresenter $presenter
     */
    public function __construct(Guard $guard, ProfilePresenter $presenter)
    {
        $this->guard = $guard;
        $this->presenter = $presenter;
    }

    /**
     * Displays the current users profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $form = $this->presenter->form($this->guard->user(), $viewing = true);

        return view('pages.profile.show.details', compact('form'));
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }
}
