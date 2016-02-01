<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;
use Orchestra\Support\Facades\HTML;

class Inquiry extends Model
{
    use HasUserTrait, HasMarkdownTrait;

    /**
     * The requests table.
     *
     * @var string
     */
    protected $table = 'inquiries';

    /**
     * The request comments pivot table.
     *
     * @var string
     */
    protected $tablePivotComments = 'inquiry_comments';

    /**
     * The belongsToMany comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, $this->tablePivotComments);
    }

    /**
     * Adds a comment to an inquiry.
     *
     * @param string $content
     *
     * @return Comment
     */
    public function createComment($content)
    {
        $attributes = [
            'content' => $content,
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        return $this->comments()->create($attributes);
    }

    /**
     * Updates the specified comment.
     *
     * @param int|string $commentId
     * @param int|string $content
     *
     * @return bool
     */
    public function updateComment($commentId, $content)
    {
        $comment = $this->comments()->findOrFail($commentId);

        $comment->content = $content;

        return $comment->save();
    }

    /**
     * Returns true / false if the current inquiry is open.
     *
     * @return bool
     */
    public function isOpen()
    {
        return !$this->closed;
    }

    /**
     * Returns the status label of the inquiry.
     *
     * @return string
     */
    public function getStatusLabel()
    {
        if ($this->isOpen()) {
            $status = 'Open';
            $class = 'btn btn-success disabled';
        } else {
            $status = 'Closed';
            $class = 'btn btn-danger disabled';
        }

        return HTML::create('span', $status, compact('class'));
    }

    /**
     * Returns the status icon of the inquiry.
     *
     * @return string
     */
    public function getStatusIcon()
    {
        if ($this->isOpen()) {
            $class = 'text-success fa fa-exclamation-circle';
        } else {
            $class = 'text-danger fa fa-check-circle';
        }

        return HTML::create('i', null, compact('class'));
    }

    /**
     * Returns the description from markdown to HTML.
     *
     * @return string
     */
    public function getDescriptionFromMarkdown()
    {
        return $this->fromMarkdown($this->description);
    }
}
