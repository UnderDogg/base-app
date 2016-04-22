<?php

namespace App\Models;

use App\Models\Traits\HasFilesTrait;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasRevisionsTrait;
use App\Models\Traits\HasUserTrait;
use Orchestra\Support\Facades\HTML;

class Comment extends Model
{
    use HasUserTrait;
    use HasFilesTrait;
    use HasMarkdownTrait;
    use HasRevisionsTrait;

    /**
     * The comment table.
     *
     * @var string
     */
    protected $table = 'comments';

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
        $user = $this->user->name;

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
