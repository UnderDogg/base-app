<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Profile\AvatarPresenter;
use App\Http\Requests\Profile\AvatarRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use RunMyBusiness\Initialcon\Initialcon;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AvatarController extends Controller
{
    /**
     * @var User
     */
    protected $user;

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
     * @param User            $user
     * @param Initialcon      $initialcon
     * @param ImageManager    $manager
     * @param AvatarPresenter $presenter
     */
    public function __construct(User $user, Initialcon $initialcon, ImageManager $manager, AvatarPresenter $presenter)
    {
        $this->user = $user;
        $this->initialcon = $initialcon;
        $this->manager = $manager;
        $this->presenter = $presenter;
    }

    /**
     * Displays the page to edit the current users avatar.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        $form = $this->presenter->form(Auth::user());

        return view('pages.profile.show.avatar.change', compact('form'));
    }

    /**
     * Processes updating the current users avatar.
     *
     * @param AvatarRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AvatarRequest $request)
    {
        if ($this->generate($request->file('image'))) {
            flash()->success('Success!', 'Successfully updated avatar!');

            return redirect()->route('profile.avatar');
        }

        flash()->error('Error!', 'There was an issue updating your avatar. Please try again.');

        return redirect()->route('profile.avatar');
    }

    /**
     * Returns a download response of the current users avatar.
     *
     * @param int|string|null $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id = null)
    {
        $user = Auth::user();

        if ($id) {
            $user = $this->user->findOrFail($id);
        }

        if ($user instanceof User) {
            // If the user doesn't have an avatar already,
            // we'll generate one on the fly.
            if (!$user->has_avatar) {
                $this->generate();
            }

            $avatar = $user->avatar();

            if ($path = $avatar->complete_path) {
                return response()->download($path);
            }

            // If the avatar doesn't exist anymore,
            // we'll delete the database record.
            $avatar->delete();

            abort(404);
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
        $user = Auth::user();

        if ($user->has_avatar) {
            // If the user has an avatar already, we'll make sure
            // we delete it before generating another.
            $user->avatar()->delete();
        }

        if ($image) {
            // Generate the uploaded images file name.
            $fileName = sprintf('%s.%s', $user->id, $image->getClientOriginalExtension());

            // If we've been given an uploaded image we'll retrieve the contents.
            $image = $this->resize($image)->stream();
        } else {
            // Generate the initials image file name.
            $fileName = $user->id.'.jpg';

            // Otherwise we'll generate and retrieve the initials image contents.
            $image = $this->initialcon->getImageData($user->present()->initials(), $user->email, $this->size);
        }

        // Generate the storage path.
        $path = $this->path($fileName);

        // Move the file into storage.
        Storage::put($path, $image);

        // Add the file to the user.
        return $user->addAvatar($path);
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

        // Return the re-sized image.
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
