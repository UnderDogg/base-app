<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * The created at human accessor.
     *
     * @return string
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->createdAtHuman();
    }

    /**
     * The updated at human accessor.
     *
     * @return string
     */
    public function getUpdatedAtHumanAttribute()
    {
        return $this->updatedAtHuman();
    }

    /**
     * Returns the models ID with a proceeding hash.
     *
     * @return string
     */
    public function getHashId()
    {
        return '#'.$this->getKey();
    }

    /**
     * Returns the created at time in a human readable format.
     *
     * @return string
     */
    public function createdAtHuman()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Returns the updated at time in a human readable format.
     *
     * @return string
     */
    public function updatedAtHuman()
    {
        return $this->updated_at->diffForHumans();
    }
}
