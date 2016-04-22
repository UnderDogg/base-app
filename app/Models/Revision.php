<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use Stevebauman\Revision\Traits\RevisionTrait;

class Revision extends Model
{
    use HasUserTrait;
    use RevisionTrait;

    /**
     * The revisions table.
     *
     * @var string
     */
    protected $table = 'revisions';
}
