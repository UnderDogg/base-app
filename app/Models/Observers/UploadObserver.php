<?php

namespace App\Models\Observers;

use App\Models\Upload;

class UploadObserver extends Observer
{
    /**
     * Runs operations when the specified upload is being deleted.
     *
     * @param Upload $upload
     */
    public function deleting(Upload $upload)
    {
        if (!$upload->deleted_at) {
            // Make sure we delete the uploaded file to save on storage.
            @unlink($upload->complete_path);
        }
    }
}
