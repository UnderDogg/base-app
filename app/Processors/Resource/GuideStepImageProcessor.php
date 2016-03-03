<?php

namespace App\Processors\Resource;

use App\Models\Guide;
use App\Policies\Resource\GuideStepImagePolicy;
use App\Processors\Processor;

class GuideStepImageProcessor extends Processor
{
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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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
     * @return bool
     */
    public function destroy($id, $stepId, $fileUuid)
    {
        if (GuideStepImagePolicy::destroy(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStep($stepId);

            $file = $step->findFile($fileUuid);

            return $file->delete();
        }

        $this->unauthorized();
    }
}
