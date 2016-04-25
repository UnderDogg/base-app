<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Admin\SetupPresenter;
use App\Http\Requests\Admin\SetupRequest;
use App\Jobs\Admin\Setup\Finish;
use App\Models\User;

class SetupController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function finish(SetupRequest $request)
    {
        $user = $this->user->newInstance();

        if ($this->dispatch(new Finish($request, $user))) {
            return view('admin.setup.complete');
        }

        flash()->error('Error!', 'There was an issue completing setup. Please try again.');

        return redirect()->route('admin.setup.begin');
    }
}
