<?php

namespace App\Models\Traits;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait CanResizeImagesTrait
{
    /**
     * Resizes the specified image to the specified dimensions.
     *
     * @param UploadedFile $file
     * @param int          $width
     * @param int          $height
     *
     * @return \Intervention\Image\Image
     */
    protected function resizeImage(UploadedFile $file, $width = 680, $height = 480)
    {
        // Make the image from intervention.
        $image = ImageManagerStatic::make($file->getRealPath());

        // Restrict image to 680 x 480.
        if (is_null($width)) {
            $width = 680;
        }
        if (is_null($height)) {
            $height = 480;
        }

        $image->resize($width, $height, function (Constraint $constraint) {
            // Prevent image up-sizing and keep aspect ratio.
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }
}
