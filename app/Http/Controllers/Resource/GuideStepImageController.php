<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Policies\Resource\GuideStepImagePolicy;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GuideStepImageController extends Controller
{
    /**
     * @var Guide
     */
    protected $guide;

    /**
     * Constructor.
     *
     * @param Guide $guide
     */
    public function __construct(Guide $guide)
    {
        $this->guide = $guide;
    }

    /**
     * Returns a download response for the specified guide step image.
     *
     * @param int|string $id
     * @param int|string $stepId
     * @param string     $fileUuid
     *
     * @throws NotFoundHttpException
     *
     * @return BinaryFileResponse
     */
    public function download($id, $stepId, $fileUuid)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStep($stepId);

        $file = $step->findFile($fileUuid);

        $headers = ['Content-Type' => $file->type];

        return response()->download($file->complete_path, null, $headers);
    }

    /**
     * Deletes the specified guide step image.
     *
     * @param int|string $id
     * @param int|string $stepId
     * @param int|string $fileUuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $stepId, $fileUuid)
    {
        if (GuideStepImagePolicy::destroy(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStep($stepId);

            $file = $step->findFile($fileUuid);

            if ($file->delete()) {
                flash()->success('Success!', 'Successfully deleted image.');

                return redirect()->back();
            }

            flash()->error('Error!', 'There was an issue deleting this image. Please try again.');

            return redirect()->back();
        }

        $this->unauthorized();
    }
}
