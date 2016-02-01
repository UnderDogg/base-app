<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;
use App\Traits\CanPurifyTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchestra\Support\Facades\HTML;

class Issue extends Model
{
    use HasUserTrait, CanPurifyTrait, HasMarkdownTrait, SoftDeletes;

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
     * The issue users pivot table.
     *
     * @var string
     */
    protected $tablePivotUsers = 'issue_users';

    /**
     * The fillable issue attributes.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];

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
     * Sets the issue's description attribute.
     *
     * @param string $description
     */
    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = $this->clean($description);
    }

    /**
     * Sets the issue's occurred at date.
     *
     * @param string $occurredAt
     */
    public function setOccurredAtAttribute($occurredAt)
    {
        if (!empty($occurredAt)) {
            $date = $this->freshTimestamp();
            $date->modify($occurredAt);

            $this->attributes['occurred_at'] = $date;
        }
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
     * The belongsToMany labels relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, $this->tablePivotLabels);
    }

    /**
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->tablePivotUsers);
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
        return $this->findCommentResolution() ? true : false;
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
     * Returns the status icon of the issue.
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
     * Returns the tag line of the issue.
     *
     * @return string
     */
    public function getTagLine()
    {
        $user = $this->user->fullname;

        $daysAgo = $this->createdAtHuman();

        $comments = count($this->comments);

        $icon = '<i class="fa fa-comments"></i>';

        $hash = $this->getHashId();

        return "$hash opened $daysAgo by $user - $icon $comments";
    }

    /**
     * Returns the created at issue tag line.
     *
     * @return string
     */
    public function getCreatedAtTagLine()
    {
        $user = $this->user->fullname;

        $daysAgo = $this->createdAtHuman();

        return "<strong>$user</strong> created ticket $daysAgo";
    }

    /**
     * Returns the occurred at issue tag line.
     *
     * @return string
     */
    public function getOccurredAtTagLine()
    {
        $daysAgo = $this->occurredAtHuman();

        return "Issue occurred $daysAgo";
    }

    /**
     * Returns the closed by user tag line.
     *
     * @return string
     */
    public function getClosedByUserTagLine()
    {
        $user = $this->closedByUser;

        if ($user instanceof User) {
            $name = $user->fullname;

            $line = "Closed by $name";
        } else {
            $line = 'Closed';
        }

        $daysAgo = $this->closedAtHuman();

        return "$line $daysAgo";
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

    /**
     * Returns the created at time in a human readable format.
     *
     * @return string|null
     */
    public function closedAtHuman()
    {
        if ($this->closed_at) {
            return $this->closed_at->diffForHumans();
        }

        return;
    }

    /**
     * Returns the occurred at time in a human readable format.
     *
     * @return string|null
     */
    public function occurredAtHuman()
    {
        if ($this->occurred_at) {
            return $this->occurred_at->diffForHumans();
        }

        return;
    }

    /**
     * Returns the occurred at time for the date selector input.
     *
     * @return string|null
     */
    public function occurredAtForInput()
    {
        if ($this->occurred_at) {
            return $this->occurred_at->format('m/d/Y g:i A');
        }

        return;
    }
}
