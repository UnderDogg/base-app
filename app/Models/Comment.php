<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;

class Comment extends Model
{
    use HasUserTrait;

    /**
     * The comment table.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The fillable comment attributes.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'content'];
}
