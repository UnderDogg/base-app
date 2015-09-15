<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * Returns the created at time in a human readable format.
     *
     * @return string
     */
    public function createdAtDaysAgo()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }
}
