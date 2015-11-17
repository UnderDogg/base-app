<?php

namespace App\Models;

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
}
