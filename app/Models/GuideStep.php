<?php

namespace App\Models;

use Lookitsatravis\Listify\Listify;

class GuideStep extends Model
{
    use Listify;

    /**
     * The guide steps model.
     *
     * @var string
     */
    protected $table = 'guide_steps';

    /**
     * The sortable group field.
     *
     * @var string
     */
    protected $sortableGroupField = 'guide_id';

    /**
     * The fillable guide step attributes.
     *
     * @var array
     */
    protected $fillable = [
        'guide_id',
        'title',
        'description',
        'position',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Initialize listify with the scope of the current step guide.
        $this->initListify([
            'scope' => $this->guide(),
        ]);
    }

    /**
     * Returns the steps current position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

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

    /**
     * Deletes all files attached to the current step.
     *
     * @return int
     */
    public function deleteFiles()
    {
        return $this->images()->delete();
    }
}
