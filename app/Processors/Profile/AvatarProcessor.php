<?php

namespace App\Processors\Profile;

use App\Http\Presenters\Profile\AvatarPresenter;
use App\Http\Requests\Profile\AvatarRequest;
use App\Models\User;
use App\Processors\Processor;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RunMyBusiness\Initialcon\Initialcon;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @var ImageManager
     */
    protected $manager;

    /**
     * The default avatar size.
     *
     * @var int
     */
    protected $size = 64;

    /**
     * Constructor.
     *
     * @param Guard           $guard
     * @param Initialcon      $initialcon
     * @param ImageManager    $manager
     * @param AvatarPresenter $presenter
     */
    public function __construct(Guard $guard, Initialcon $initialcon, ImageManager $manager, AvatarPresenter $presenter)
    {
        $this->guard = $guard;
        $this->initialcon = $initialcon;
        $this->manager = $manager;
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

    /**
     * Updates the current users profile avatar with their uploaded image.
     *
     * @param AvatarRequest $request
     *
     * @return bool
     */
    public function update(AvatarRequest $request)
    {
        if ($request->has('generate')) {
            return $this->generate();
        } else {
            $image = $request->file('image');

            if ($image instanceof UploadedFile) {
                return $this->generate($image);
            }
        }

        return false;
    }

    /**
     * Returns a download response of the current users avatar.
     *
     * This will also generate a new avatar for the
     * user if the user does not have an avatar.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            // If the user doesn't have an avatar already,
            // we'll generate one on the fly.
            if (!$user->hasAvatar()) {
                $this->generate();
            }

            $avatar = $user->avatar();

            return response()->download($avatar->getCompletePath());
        }

        throw new NotFoundHttpException();
    }

    /**
     * Generates an avatar based on the current users initials.
     *
     * @param $image UploadedFile
     *
     * @throws \Exception
     *
     * @return bool
     */
    protected function generate(UploadedFile $image = null)
    {
        $user = $this->guard->user();

        if ($user instanceof User) {
            if ($user->hasAvatar()) {
                // If the user has an avatar already, we'll make sure
                // we delete it before generating another.
                $user->avatar()->delete();
            }

            if ($image) {
                // Generate the uploaded images file name.
                $fileName = sprintf('%s.%s', $user->getKey(), $image->getClientOriginalExtension());

                // If we've been given an uploaded image we'll retrieve the contents.
                $image = $this->resize($image)->stream();
            } else {
                // Generate the initials image file name.
                $fileName = $user->getKey().'.jpg';

                // Otherwise we'll generate and retrieve the initials image contents.
                $image = $this->initialcon->getImageData($user->getInitials(), $user->getRecipientEmail(), $this->size);
            }

            // Generate the storage path.
            $path = $this->path($fileName);

            // Move the file into storage.
            Storage::put($path, $image);

            // Add the file to the user.
            $user->addAvatar($path);

            return true;
        }

        return false;
    }

    /**
     * Re-sizes the specified uploaded image.
     *
     * @param UploadedFile $image
     *
     * @return \Intervention\Image\Image
     */
    protected function resize(UploadedFile $image)
    {
        // Make the image from intervention.
        $image = $this->manager->make($image->getRealPath());

        // Resize the image.
        $image->resize($this->size, $this->size);

        return $image;
    }

    /**
     * Generates a storage path for avatar images to reside.
     *
     * @param string|int $fileName
     *
     * @return string
     */
    protected function path($fileName)
    {
        return sprintf('%s%s%s%s%s',
            'uploads',
            DIRECTORY_SEPARATOR,
            'avatars',
            DIRECTORY_SEPARATOR,
            $fileName
        );
    }
}
