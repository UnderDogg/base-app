<?php

namespace App\Models;

use Rutorika\Sortable\SortableTrait;

class GuideStep extends Model
{
    use SortableTrait;

    /**
     * The guide steps model.
     *
     * @var string
     */
    protected $table = 'guide_steps';

    /**
     * The fillable guide step attributes.
     *
     * @var array
     */
    protected $fillable = [
        'guide_id',
        'title',
        'description',
    ];

    /**
     * The belongsTo guide relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    /**
     * The morphMany images relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
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

        return $this->images()->create(compact('uuid', 'name', 'type', 'path', 'size'));
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
        return $this->images()->where(compact('uuid'))->firstOrFail();
    }
}
