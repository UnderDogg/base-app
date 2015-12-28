<?php

namespace App\Processors\Profile;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Presenters\Profile\ProfilePresenter;
use App\Processors\Processor;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     *
     * @throws NotFoundHttpException
     */
    public function show()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $form = $this->presenter->form($user, $viewing = true);

            return view('pages.profile.show.details', compact('user', 'form'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Displays the form for editing the current users profile.
     *
     * @return \Illuminate\View\View
     *
     * @throws NotFoundHttpException
     */
    public function edit()
    {
        $user = $this->guard->user();

        if ($user instanceof User && !$user->isFromAd()) {
            $form = $this->presenter->form($user);

            return view('pages.profile.show.edit-details', compact('user', 'form'));
        }

        throw new NotFoundHttpException();
    }

    public function update()
    {
        $user = $this->guard->user();

        if ($user instanceof User && !$user->isFromAd()) {
            
        }

        throw new NotFoundHttpException();
    }
}
