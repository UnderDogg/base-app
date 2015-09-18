<?php

namespace App\Models;

use Orchestra\Support\Traits\QueryFilterTrait;
use Orchestra\Support\Facades\HTML;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CanPurifyTrait;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;

class Issue extends Model
{
    use HasUserTrait, CanPurifyTrait, HasMarkdownTrait, QueryFilterTrait, SoftDeletes;

    /**
     * The issues table.
     *
     * @var string
     */
    protected $table = 'issues';

    /**
     * The issue labels pivot table.
     *
     * @var string
     */
    protected $tablePivotLabels = 'issue_labels';

    /**
     * The issue comments pivot table.
     *
     * @var string
     */
    protected $tablePivotComments = 'issue_comments';

    /**
     * The fillable issue attributes.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

    /**
     * Sets the issue's description attribute.
     *
     * @param $description
     */
    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = $this->clean($description);
    }

    /**
     * The belongsToMany labels relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, $this->tablePivotLabels);
    }

    /**
     * The belongsToMany comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, $this->tablePivotComments)->withPivot(['resolution']);
    }

    /**
     * Adds a comment to an issue.
     *
     * @param string $content
     * @param bool   $resolution
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createComment($content, $resolution = false)
    {
        $attributes = [
            'content' => $content,
            'user_id' => auth()->user()->getAuthIdentifier(),
        ];

        // Make sure we only allow one comment resolution
        if($this->hasCommentResolution()) $resolution = false;

        return $this->comments()->create($attributes, compact('resolution'));
    }

    /**
     * Updates the specified comment.
     *
     * @param int|string $commentId
     * @param int|string $content
     * @param bool|false $resolution
     *
     * @return bool
     */
    public function updateComment($commentId, $content, $resolution = false)
    {
        $comment = $this->comments()->findOrFail($commentId);

        // // Make sure we only allow one comment resolution
        if (!$this->hasCommentResolution() || $comment->pivot->resolution) {
            $this->comments()->updateExistingPivot($comment->getKey(), compact('resolution'));
        }

        $comment->content = $content;

        return $comment->save();
    }

    /**
     * Returns the issues comment resolution.
     *
     * @return null|Comment
     */
    public function findCommentResolution()
    {
        return $this->comments()->wherePivot('resolution', true)->first();
    }

    /**
     * Returns true / false if the current issue has a resolution.
     *
     * @return bool
     */
    public function hasCommentResolution()
    {
        return ($this->findCommentResolution() ? true : false);
    }

    /**
     * Adds a label to an issue.
     *
     * @param Label $label
     *
     * @return bool
     */
    public function addLabel(Label $label)
    {
        $this->labels()->attach($label);

        return true;
    }

    /**
     * Returns true or false if the issue is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * Returns true or false if the issue is open.
     *
     * @return bool
     */
    public function isOpen()
    {
        return !$this->closed;
    }

    /**
     * Returns the status label of the issue.
     *
     * @return string
     */
    public function statusLabel()
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
     * Returns the tag line of the issue.
     *
     * @return string
     */
    public function tagLine()
    {
        $user = $this->user->fullname;

        $daysAgo = $this->createdAtDaysAgo();

        $comments = count($this->comments);

        return "$user opened this issue $daysAgo - $comments Comment(s)";
    }

    /**
     * Returns the description from markdown to HTML.
     *
     * @return string
     */
    public function descriptionFromMarkdown()
    {
        return $this->fromMarkdown($this->description);
    }

    /**
     * Search an issue based on the specified keyword.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $keyword
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $keyword = '')
    {
        return $this->setupWildcardQueryFilter($query, $keyword, ['title', 'description']);
    }
}
