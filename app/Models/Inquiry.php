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
     * The belongsTo category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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
     * Returns true / false if current inquiry is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return !$this->isOpen();
    }

    /**
     * Returns true / false if the current inquiry is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
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
    public function getCategoryLabelAttribute()
    {
        $category = $this->category;

        if ($category instanceof Category) {
            $name = "<i class='fa fa-tag'></i> $category->name";

            return "<span class='label label-primary'>$name</span>";
        }

        return null;
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
