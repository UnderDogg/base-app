<?php

namespace App\Models;

use App\Models\Presenters\IssuePresenter;
use App\Models\Traits\HasCommentsTrait;
use App\Models\Traits\HasFilesTrait;
use App\Models\Traits\HasLabelsTrait;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasPresenter;
use App\Models\Traits\HasRevisionsTrait;
use App\Models\Traits\HasUsersTrait;
use App\Models\Traits\HasUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchestra\Support\Facades\HTML;

class Issue extends Model
{
    use SoftDeletes,
        HasUsersTrait,
        HasUserTrait,
        HasFilesTrait,
        HasLabelsTrait,
        HasMarkdownTrait,
        HasRevisionsTrait,
        HasPresenter,
        HasCommentsTrait {
        comments as traitComments;
    }

    /**
     * The columns to track revisions on.
     *
     * @var array
     */
    protected $revisionColumns = [
        'title',
        'description',
    ];

    /**
     * The fillable issue attributes.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * The fields that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'closed_at',
        'occurred_at',
    ];

    /**
     * Sets the issue's occurred at date.
     *
     * @param string $occurredAt
     */
    public function setOccurredAtAttribute($occurredAt)
    {
        $occurredAt = $occurredAt ? $this->freshTimestamp()->modify($occurredAt) : null;

        $this->attributes['occurred_at'] = $occurredAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommentsPivotTable()
    {
        return 'issue_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelsPivotTable()
    {
        return 'issue_labels';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersPivotTable()
    {
        return 'issue_users';
    }

    /**
     * {@inheritdoc}
     */
    public function comments()
    {
        return $this->traitComments()->withPivot(['resolution']);
    }

    /**
     * The belongsTo closed by user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function closedByUser()
    {
        return $this->belongsTo(User::class, 'closed_by_user_id');
    }

    /**
     * Returns a new presenter instance.
     *
     * @return IssuePresenter
     */
    public function present()
    {
        return new IssuePresenter($this);
    }

    /**
     * The open issues scope.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOpen(Builder $query)
    {
        return $query->where(['closed' => false]);
    }

    /**
     * The closed issues scope.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeClosed(Builder $query)
    {
        return $query->where(['closed' => true]);
    }

    /**
     * Scopes the specified query by a labels name.
     *
     * @param Builder $query
     * @param string  $label
     *
     * @return Builder
     */
    public function scopeLabel(Builder $query, $label = '')
    {
        if (!empty($label)) {
            $query->whereHas('labels', function (Builder $query) use ($label) {
                return $query->where(['name' => $label]);
            });
        }

        return $query;
    }

    /**
     * Scopes the specified query by a labels name.
     *
     * @param Builder $query
     * @param string  $resolution
     *
     * @return Builder
     */
    public function scopeHasResolution(Builder $query, $resolution = '')
    {
        if (!empty($resolution)) {
            if ($resolution === 'yes') {
                $query->whereHas('comments', function (Builder $query) {
                    $query->where(['resolution' => true]);
                });
            }
        }

        return $query;
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
        return $this->findCommentResolution() instanceof Comment;
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
     * Returns the description in raw HTML from markdown.
     *
     * @return string
     */
    public function getDescriptionFromMarkdownAttribute()
    {
        return $this->fromMarkdown($this->description);
    }

    /**
     * Returns the created at time in a human readable format.
     *
     * @return string|null
     */
    public function getClosedAtHumanAttribute()
    {
        if ($this->closed_at) {
            return $this->closed_at->diffForHumans();
        }
    }

    /**
     * Returns the occurred at time in a human readable format.
     *
     * @return string|null
     */
    public function getOccurredAtHumanAttribute()
    {
        if ($this->occurred_at) {
            return $this->occurred_at->diffForHumans();
        }
    }

    /**
     * Returns the occurred at time for the date selector input.
     *
     * @return string|null
     */
    public function getOccurredAtForInputAttribute()
    {
        if ($this->occurred_at) {
            return $this->occurred_at->format('F jS Y, h:i a');
        }
    }
}
