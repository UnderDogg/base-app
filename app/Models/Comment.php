<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;
use App\Traits\CanPurifyTrait;
use Orchestra\Support\Facades\HTML;

class Comment extends Model
{
    use HasUserTrait, HasMarkdownTrait, CanPurifyTrait;

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
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * The appends attributes.
     *
     * @var array
     */
    protected $appends = [
        'created_at_human',
        'created_at_tag_line',
        'content_from_markdown',
        'resolution',
    ];

    /**
     * Set the comments content.
     *
     * @param $content
     */
    public function setContentAttribute($content)
    {
        $this->attributes['content'] = $this->clean($content);
    }

    /**
     * The resolution accessor.
     *
     * @return bool
     */
    public function getResolutionAttribute()
    {
        if ($this->pivot) {
            return $this->pivot->resolution;
        }

        return false;
    }

    /**
     * The created at tag line accessor.
     *
     * @return string
     */
    public function getCreatedAtTagLineAttribute()
    {
        $user = $this->user->fullname;

        $daysAgo = $this->created_at_human;

        if ($this->resolution) {
            $created = "created resolution $daysAgo";
        } else {
            $created = "commented $daysAgo";
        }

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
}
