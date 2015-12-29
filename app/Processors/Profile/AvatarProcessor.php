<?php

namespace App\Processors\Profile;

use App\Http\Presenters\Profile\AvatarPresenter;
use App\Http\Requests\Profile\AvatarRequest;
use App\Models\Upload;
use App\Models\User;
use App\Processors\Processor;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Storage;
use RunMyBusiness\Initialcon\Initialcon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AvatarProcessor extends Processor
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var Initialcon
     */
    protected $initialcon;

    /**
     * @var AvatarPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guard           $guard
     * @param Initialcon      $initialcon
     * @param AvatarPresenter $presenter
     */
    public function __construct(Guard $guard, Initialcon $initialcon, AvatarPresenter $presenter)
    {
        $this->guard = $guard;
        $this->initialcon = $initialcon;
        $this->presenter = $presenter;
    }

    /**
     * Displays the page to edit the current users avatar.
     *
     * @throws NotFoundHttpException
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $form = $this->presenter->form($user);

            return view('pages.profile.show.avatar.change', compact('form'));
        }

        throw new NotFoundHttpException();
    }

    public function update(AvatarRequest $request)
    {
        if ($request->has('generate')) {
            return $this->generate();
        } else {
        }
    }

    /**
     * Returns a download response of the current users avatar.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            $avatar = $user->avatar();

            if ($avatar instanceof Upload) {
                return response()->download($avatar->getCompletePath());
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * Generates an avatar based on the current users initials.
     *
     * @throws \Exception
     *
     * @return bool
     */
    protected function generate()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            if ($user->hasAvatar()) {
                // If the user has an avatar already, we'll make sure
                // we delete it before generating another.
                $user->avatar()->delete();
            }

            // Generate and retrieve the initials image.
            $image = $this->initialcon->getImageData($user->getInitials(), $user->getRecipientEmail());

            // Generate the storage path.
            $path = sprintf('%s%s%s%s%s',
                'uploads',
                DIRECTORY_SEPARATOR,
                'avatars',
                DIRECTORY_SEPARATOR,
                $user->getKey().'.jpg'
            );

            // Move the file into storage.
            Storage::put($path, $image);

            // Add the file to the user.
            $user->addAvatar($path);

            return true;
        }

        return false;
    }
}
