<?php

namespace App\Models;

use App\Models\Traits\HasFilesTrait;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasRevisionsTrait;
use App\Models\Traits\HasUserTrait;
use Orchestra\Support\Facades\HTML;

class Comment extends Model
{
    use HasUserTrait, HasFilesTrait, HasMarkdownTrait, HasRevisionsTrait;

    /**
     * The columns to track revisions on.
     *
     * @var array
     */
    protected $revisionColumns = ['content'];

    /**
     * The fillable comment attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * The resolution accessor.
     *
     * @return bool
     */
    public function getResolutionAttribute()
    {
        return $this->pivot ? $this->pivot->resolution : false;
    }

    /**
     * The created at tag line accessor.
     *
     * @return string
     */
    public function getCreatedAtTagLineAttribute()
    {
        $user = $this->user->name;

        $daysAgo = $this->created_at_human;

        $created = ($this->resolution ? "created resolution $daysAgo" : "commented $daysAgo");

        $line = HTML::create('span', $created, ['class' => 'hidden-xs']);

        return sprintf('<strong>%s</strong> %s', $user, $line);
    }

    /**
     * The content from markdown accessor.
     *
     * @return string
     */
    public function getContentFromMarkdownAttribute()
    {
        return $this->fromMarkdown($this->content);
    }

    /**
     * Returns the comments hash ID attribute.
     *
     * @return string
     */
    public function getHashIdAttribute()
    {
        return sprintf('#comment-%s', $this->id);
    }
}
