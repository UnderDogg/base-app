<?php

namespace App\Models\Traits;

use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait HasFilesTrait
{
    /**
     * The morphMany images relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }

    /**
     * Creates a new file attached to the current step.
     *
     * @param string $name
     * @param string $type
     * @param int    $size
     * @param string $path
     *
     * @return Upload
     */
    public function addFile($name, $type, $size, $path)
    {
        $uuid = uuid();

        return $this->files()->create(compact('uuid', 'name', 'type', 'path', 'size'));
    }

    /**
     * Uploads and adds a file to the current record.
     *
     * @param UploadedFile $file
     * @param string       $name
     * @param string       $path
     *
     * @return Upload
     */
    public function uploadFile(UploadedFile $file, $name, $path)
    {
        // Move the file into storage.
        Storage::put($path, file_get_contents($file->getPath()));

        return $this->addFile($name, $file->getClientMimeType(), $file->getClientSize(), $path);
    }

    /**
     * Finds a step image by the specified UUID.
     *
     * @param string $uuid
     *
     * @return Upload
     */
    public function findFile($uuid)
    {
        return $this->files()->where(compact('uuid'))->firstOrFail();
    }

    /**
     * Deletes all files attached to the current step.
     *
     * @return int
     */
    public function deleteFiles()
    {
        return $this->files()->delete();
    }
}
