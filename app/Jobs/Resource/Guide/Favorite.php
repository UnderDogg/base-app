<?php

namespace App\Jobs\Resource\Guide;

use App\Jobs\Job;
use App\Models\Guide;

class Favorite
{
    /**
     * @var Guide
     */
    protected $guide;

    /**
     * Constructor.
     *
     * @param Guide $guide
     */
    public function __construct(Guide $guide)
    {
        $this->guide = $guide;
    }

    /**
     * Execute the job.
     *
     * @return Guide|bool
     */
    public function handle()
    {
        if ($this->guide->hasFavorite() && $this->guide->unFavorite()) {
            // If the guide is currently favorited, we'll assume
            // the user is wanting to 'un-favorite' the guide.
            return $this->guide;
        } elseif ($this->guide->favorite()) {
            return $this->guide;
        }

        return false;
    }
}
