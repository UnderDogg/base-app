<?php

namespace App\Models;

use App\Models\Traits\HasFilesTrait;
use Lookitsatravis\Listify\Listify;

class GuideStep extends Model
{
    use Listify, HasFilesTrait;

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
     * Alias for guide step images morphMany relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->files();
    }
}
