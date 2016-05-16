<?php

namespace App\Models;

use App\Models\Traits\HasRevisionsTrait;
use App\Models\Traits\HasUserTrait;

class Wiki extends Model
{
    use HasUserTrait, HasRevisionsTrait;
}
