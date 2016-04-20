<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Profile\ProfilePresenter;
use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @var ProfilePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param ProfilePresenter $presenter
     */
    public function __construct(ProfilePresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Displays the current users profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        $form = $this->presenter->form($user, $viewing = true);

        return view('pages.profile.show.details.show', compact('user', 'form'));
    }

    /**
     * Displays the form for editing the current users.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        $form = $this->presenter->form($user);

        return view('pages.profile.show.details.edit', compact('user', 'form'));
    }

    /**
     * Updates the current users profile.
     *
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $user = Auth::user();

        if (!$user->from_ad) {
            $user->name = $request->input('full_name', $user->name);
            $user->email = $request->input('email', $user->email);

            $user->save();

            flash()->success('Success!', 'Your profile has been updated.');

            return redirect()->route('profile.show');
        }

        flash()->error('Error!', 'There was an issue updating your profile. Please try again.');

        return redirect()->route('profile.edit');
    }
}
