<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
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
