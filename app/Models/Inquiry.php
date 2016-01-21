<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;
use App\Models\Traits\HasUserTrait;

class Inquiry extends Model
{
    use HasUserTrait;

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
     * Returns true / false if the current inquiry is open.
     *
     * @return bool
     */
    public function isOpen()
    {
        return ! $this->closed;
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
}
