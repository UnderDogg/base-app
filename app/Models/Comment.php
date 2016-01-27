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
     * Returns true / false if the comment is a resolution.
     *
     * @return bool
     */
    public function isResolution()
    {
        if ($this->pivot) {
            return $this->pivot->resolution;
        }

        return false;
    }

    /**
     * The resolution accessor.
     *
     * @return bool
     */
    public function getResolutionAttribute()
    {
        return $this->isResolution();
    }

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
     * Displays the commented 'daysAgo' tag line for comments.
     *
     * @return string
     */
    public function getCreatedAtTagLine()
    {
        $user = $this->user->fullname;

        $daysAgo = $this->createdAtHuman();

        if ($this->isResolution()) {
            $created = "created resolution $daysAgo";
        } else {
            $created = "commented $daysAgo";
        }

        $line = HTML::create('span', $created, ['class' => 'hidden-xs']);

        return sprintf('<strong>%s</strong> %s', $user, $line);
    }

    /**
     * The created at tag line accessor.
     *
     * @return string
     */
    public function getCreatedAtTagLineAttribute()
    {
        return $this->getCreatedAtTagLine();
    }

    /**
     * Returns content from markdown to HTML.
     *
     * @return string
     */
    public function getContentFromMarkdown()
    {
        return $this->fromMarkdown($this->content);
    }

    /**
     * The content from markdown accessor.
     *
     * @return string
     */
    public function getContentFromMarkdownAttribute()
    {
        return $this->getContentFromMarkdown();
    }
}
