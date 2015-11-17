<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Orchestra\Support\Facades\HTML;

class Guide extends Model
{
    /**
     * The guides table.
     *
     * @var string
     */
    protected $table = 'guides';

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
     * @return Guide
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function locate($slug, array $with = [])
    {
        return $this->query()->where(compact('slug'))->with($with)->firstOrFail();
    }

    /**
     * Returns the published at date in a human readable format.
     *
     * @return string|null
     */
    public function publishedOnHuman()
    {
        if ($this->published) {
            return Carbon::createFromTimestamp(strtotime($this->published_on))->diffForHumans();
        }

        return;
    }

    /**
     * Returns a summary of the guide by limiting the description attribute.
     *
     * @return string
     */
    public function summary()
    {
        return Str::limit($this->description, 25);
    }

    /**
     * Returns an HTML string of the published state of the current guide.
     *
     * @return string
     */
    public function publishedLabel()
    {
        $date = $this->publishedOnHuman();

        $published = ($this->published ? "Yes ($date)": 'No');

        $class = 'label ' . ($this->published ? 'label-success' : 'label-danger');

        return HTML::create('span', $published, compact('class'));
    }
}
