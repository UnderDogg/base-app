<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;
use App\Models\Traits\HasMarkdown;
use App\Models\Traits\HasUserTrait;

class Comment extends Model
{
    use HasUserTrait, HasMarkdown;

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

    /**
     * Displays the commented 'daysAgo' tag line for comments.
     *
     * @return string
     */
    public function tagLine()
    {
        $daysAgo = $this->createdAtDaysAgo();

        return HTML::create('span', "commented $daysAgo", ['class' => 'text-muted']);
    }

    /**
     * Returns content from markdown to HTML.
     *
     * @return string
     */
    public function contentFromMarkdown()
    {
        return $this->fromMarkdown($this->content);
    }
}
