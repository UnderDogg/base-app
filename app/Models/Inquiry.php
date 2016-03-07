<?php

namespace App\Models;

use App\Models\Traits\HasComments;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;

class Inquiry extends Model
{
    use HasUserTrait, HasComments, HasMarkdownTrait;

    /**
     * The requests table.
     *
     * @var string
     */
    protected $table = 'inquiries';

    /**
     * {@inheritdoc}
     */
    public function getCommentsPivotTable()
    {
        return 'inquiry_comments';
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
     * Returns the status icon of the inquiry.
     *
     * @return string|null
     */
    public function getCategoryLabelAttribute()
    {
        $tag = $this->category_tag;

        if (!empty($tag)) {
            return "<span class='label label-primary'>$tag</span>";
        }
    }

    /**
     * Returns the category tag of the inquiry.
     *
     * @return string|null
     */
    public function getCategoryTagAttribute()
    {
        $name = $this->category_name;

        if (!empty($name)) {
            return "<i class='fa fa-tag'></i> $name";
        }
    }

    /**
     * Returns the inquiry category's name.
     *
     * @return string|null
     */
    public function getCategoryNameAttribute()
    {
        $category = $this->category;

        if ($category instanceof Category) {
            return $category->name;
        }
    }

    /**
     * Accessor for the tag line of the issue.
     *
     * @return string
     */
    public function getTagLineAttribute()
    {
        $user = $this->user->name;

        $daysAgo = $this->created_at_human;

        $comments = count($this->comments);

        $icon = '<i class="fa fa-comments"></i>';

        $hash = $this->hash_id;

        return "$hash created $daysAgo by $user - $icon $comments";
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
