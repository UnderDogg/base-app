<?php

namespace App\Models;

use App\Models\Traits\HasFavoritesTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Orchestra\Support\Facades\HTML;

class Guide extends Model
{
    use HasFavoritesTrait;

    /**
     * The guides table.
     *
     * @var string
     */
    protected $table = 'guides';

    /**
     * The fillable guide attributes.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The hasMany steps relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps()
    {
        return $this->hasMany(GuideStep::class, 'guide_id');
    }

    /**
     * Locates a guide by its slug.
     *
     * @param string $slug
     * @param array  $with
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return Guide
     */
    public function locate($slug, array $with = [])
    {
        return $this->query()->where(compact('slug'))->with($with)->firstOrFail();
    }

    /**
     * Adds a step to the current guide.
     *
     * @param string      $title
     * @param string|null $description
     *
     * @return GuideStep
     */
    public function addStep($title, $description = null)
    {
        return $this->steps()->create(compact('title', 'description'));
    }

    /**
     * Finds the guide step by the specified ID.
     *
     * @param int|string $id
     *
     * @return null|GuideStep
     */
    public function findStep($id)
    {
        return $this->steps()->findOrFail($id);
    }

    /**
     * Finds a guide step by its current position.
     *
     * @param int $position
     *
     * @return GuideStep|null
     */
    public function findStepByPosition($position)
    {
        return $this->steps()->where(compact('position'))->firstOrFail();
    }

    /**
     * Returns a summary of the guide by limiting the description attribute.
     *
     * @return string
     */
    public function getSummaryAttribute()
    {
        return Str::limit($this->description, 25);
    }

    /**
     * Returns an HTML string of the published state of the current guide.
     *
     * @return string
     */
    public function getPublishedLabelAttribute()
    {
        $date = $this->published_on_human;

        $published = ($this->published ? "$date" : 'No');

        $class = 'label '.($this->published ? 'label-success' : 'label-danger');

        return HTML::create('span', $published, compact('class'));
    }

    /**
     * Returns the published at date in a human readable format.
     *
     * @return string|null
     */
    public function getPublishedOnHumanAttribute()
    {
        if ($this->published) {
            return Carbon::createFromTimestamp(strtotime($this->published_on))->diffForHumans();
        }

        return;
    }
}
