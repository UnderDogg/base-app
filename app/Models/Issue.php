<?php

namespace App\Models;

use Orchestra\Support\Traits\QueryFilterTrait;
use Orchestra\Support\Facades\HTML;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasMarkdown;
use App\Models\Traits\HasUserTrait;

class Issue extends Model
{
    use HasUserTrait, HasMarkdown, QueryFilterTrait, SoftDeletes;

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
    protected $tableLabels = 'issue_labels';

    /**
     * The issue comments pivot table.
     *
     * @var string
     */
    protected $tableComments = 'issue_comments';

    /**
     * The fillable issue attributes.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

    /**
     * The belongsToMany labels relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, $this->tableLabels);
    }

    /**
     * The belongsToMany comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, $this->tableComments);
    }

    /**
     * Adds a comment to an issue.
     *
     * @param string $content
     *
     * @return \Illuminate\Database\Eloquent\Model
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
