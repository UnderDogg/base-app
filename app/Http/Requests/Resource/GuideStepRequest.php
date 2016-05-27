<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;
use App\Models\Guide;
use App\Models\GuideStep;
use Illuminate\Http\UploadedFile;

class GuideStepRequest extends Request
{
    /**
     * The attachment request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'       => 'image',
            'title'       => 'required|min:5',
            'description' => 'min:5',
        ];
    }

    /**
     * Allows only logged in users to upload attachments.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Persist the changes.
     *
     * @param Guide     $guide
     * @param GuideStep $step
     *
     * @return GuideStep|bool
     */
    public function persist(Guide $guide, GuideStep $step)
    {
        $step->guide_id = $guide->id;
        $step->title = $this->input('title');
        $step->description = $this->input('description');

        if ($step->save()) {
            // Retrieve the image for the step.
            $file = $this->file('image');

            if ($file instanceof UploadedFile) {
                $step->deleteFiles();

                $step->uploadFile($file, $path = null, $resize = true);
            }

            // No image was uploaded, we'll return the step.
            return $step;
        }

        return false;
    }
}
