<?php

namespace App\Processors\Profile;

use App\Http\Presenters\Profile\ProfilePresenter;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
use App\Processors\Processor;
use Illuminate\Contracts\Auth\Guard;
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
     * @throws NotFoundHttpException
     *
     * @return \Illuminate\View\View
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
     * @throws NotFoundHttpException
     *
     * @return \Illuminate\View\View
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

    /**
     * Updates the current users profile.
     *
     * @param UpdateRequest $request
     *
     * @throws NotFoundHttpException
     *
     * @return bool
     */
    public function update(UpdateRequest $request)
    {
        $user = $this->guard->user();

        // Double check that we have the correct user instance
        // and they are not from active directory.
        if ($user instanceof User && !$user->isFromAd()) {
            $user->fullname = $request->input('full_name', $user->fullname);
            $user->email = $request->input('email', $user->getRecipientEmail());

            return $user->save();
        }

        throw new NotFoundHttpException();
    }
}
