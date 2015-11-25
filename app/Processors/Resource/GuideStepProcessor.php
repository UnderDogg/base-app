<?php

namespace App\Processors\Resource;

use App\Http\Requests\Resource\GuideStepMoveRequest;
use App\Http\Requests\Resource\GuideStepRequest;
use App\Http\Presenters\Resource\GuideStepPresenter;
use App\Models\Guide;
use App\Models\GuideStep;
use App\Models\Upload;
use App\Processors\Processor;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GuideStepProcessor extends Processor
{
    /**
     * @var Guide
     */
    protected $guide;

    /**
     * @var ImageManager
     */
    protected $manager;

    /**
     * @var GuideStepPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guide             $guide
     * @param ImageManager       $manager
     * @param GuideStepPresenter $presenter
     */
    public function __construct(Guide $guide, ImageManager $manager, GuideStepPresenter $presenter)
    {
        $this->guide = $guide;
        $this->manager = $manager;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified guide steps.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $guide = $this->guide->locate($id);

        $steps = $this->presenter->table($guide);

        $navbar = $this->presenter->navbar($guide);

        return view('pages.resources.guides.steps.index', compact('steps', 'navbar', 'guide'));
    }

    /**
     * Displays the form to create a guide step.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $guide = $this->guide->locate($id);

        $form = $this->presenter->form($guide, $guide->steps()->getRelated());

        return view('pages.resources.guides.steps.create', compact('form'));
    }

    /**
     * Creates a new step and attaches uploaded images to the step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     *
     * @return GuideStep|bool
     */
    public function store(GuideStepRequest $request, $id)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->addStep($request->input('title'), $request->input('description'));

        if ($step instanceof GuideStep) {
            $file = $request->file('image');

            if ($file instanceof UploadedFile) {
                // Looks like an image was uploaded, we'll move
                // it into storage and add it to the step.
                return $this->handleUpload($guide, $step, $file);
            }

            // No image was uploaded, we'll return the step.
            return $step;
        }

        return false;
    }

    /**
     * Displays the form for editing the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $stepPosition)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStepByPosition($stepPosition);

        $form = $this->presenter->form($guide, $step);

        return view('pages.resources.guides.steps.edit', compact('form'));
    }

    /**
     * Updates the specified 
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     * @param int              $stepPosition
     *
     * @return GuideStep|bool
     */
    public function update(GuideStepRequest $request, $id, $stepPosition)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStepByPosition($stepPosition);

        $step->title = $request->input('title', $step->title);
        $step->description = $request->input('description', $step->description);

        if ($step->save()) {
            // If saving the step is successful, we'll process the file upload if there is one.
            $file = $request->file('image');

            if ($file instanceof UploadedFile) {
                $step->deleteFiles();

                return $this->handleUpload($guide, $step, $file);
            }

            return $step;
        }

        return false;
    }

    /**
     * Moves the guide step to the specified position.
     *
     * @param GuideStepMoveRequest $request
     * @param int|string           $id
     * @param int                  $stepId
     *
     * @return bool
     */
    public function move(GuideStepMoveRequest $request, $id, $stepId)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->steps()->findOrFail($stepId);

        if ($step instanceof GuideStep) {
            return $step->insertAt($request->input('position'));
        }

        return false;
    }

    /**
     * Returns a download response for the specified guide step image.
     *
     * @param int|string $id
     * @param int|string $stepId
     * @param string     $fileUuid
     *
     * @return bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id, $stepId, $fileUuid)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->steps()->findOrFail($stepId);

        if ($step instanceof GuideStep) {
            $file = $step->findFile($fileUuid);

            return response()->download($file->getCompletePath());
        }

        return false;
    }

    /**
     * Handle the guide step image upload.
     *
     * @param Guide        $guide
     * @param GuideStep    $step
     * @param UploadedFile $file
     *
     * @return GuideStep|bool
     */
    protected function handleUpload(Guide $guide, GuideStep $step, UploadedFile $file)
    {
        // Validate file name length.
        if(strlen($file->getClientOriginalName()) > 70) {
            abort(422, 'File name is too large');
        }

        // Generate a file name with UUID and its extension.
        $name = uuid() . "." . $file->getClientOriginalExtension();

        // Generate the storage path.
        $path = $guide->getKey() . DIRECTORY_SEPARATOR . $name;

        // Resize the uploaded image if the user requested it.
        $image = $this->resizeUploadedImage($file);

        // Move the file into storage.
        Storage::put($path, $image->stream());

        // Add the file to the step.
        $upload = $step->addFile($image->filename, $image->mime(), $image->filesize(), $path);

        if ($upload instanceof Upload) {
            return $step;
        }

        // Failed creating the upload record, we'll delete the step that was just created.
        $step->delete();

        return false;
    }

    /**
     * Resize's the uploaded image.
     *
     * @param UploadedFile $file
     *
     * @return \Intervention\Image\Image
     */
    protected function resizeUploadedImage(UploadedFile $file)
    {
        // Make the image from intervention.
        $image = $this->manager->make($file->getRealPath());

        // Restrict image to 680 x 480.
        $width = 680;
        $height = 480;

        $image->resize($width, $height, function (Constraint $constraint) {
            // Prevent image up-sizing and keep aspect ratio.
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }
}
