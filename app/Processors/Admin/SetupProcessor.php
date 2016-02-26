<?php

namespace App\Processors\Admin;

use App\Http\Presenters\Admin\SetupPresenter;
use App\Http\Requests\Admin\SetupRequest;
use App\Jobs\Admin\Setup\Finish;
use App\Models\User;
use App\Processors\Processor;

class SetupProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var SetupPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param User           $user
     * @param SetupPresenter $presenter
     */
    public function __construct(User $user, SetupPresenter $presenter)
    {
        $this->user = $user;
        $this->presenter = $presenter;
    }

    /**
     * Displays the welcome page for setting up administration.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('admin.setup.welcome');
    }

    /**
     * Displays the form for setting up administration.
     *
     * @return \Illuminate\View\View
     */
    public function begin()
    {
        $form = $this->presenter->form();

        return view('admin.setup.begin', compact('form'));
    }

    /**
     * Finishes the administration setup.
     *
     * @param SetupRequest $request
     *
     * @return bool
     */
    public function finish(SetupRequest $request)
    {
        $user = $this->user->newInstance();

        return $this->dispatch(new Finish($request, $user));
    }
}
