<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use Orchestra\Support\Facades\HTML;

class ServiceRecord extends Model
{
    const STATUS_ONLINE     = 1;
    const STATUS_DEGRADED   = 2;
    const STATUS_OFFLINE    = 3;
    const STATUS_UNKNOWN    = 4;

    use HasMarkdownTrait;

    /**
     * The service records table.
     *
     * @var string
     */
    protected $table = 'service_records';

    /**
     * The fillable service record attributes.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * The belongsTo service relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * The status label accessor.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        switch($this->status) {
            case static::STATUS_ONLINE:
                $class = 'success';
                $title = 'Online';
                break;
            case static::STATUS_DEGRADED:
                $class = 'warning';
                $title = 'Degraded';
                break;
            case static::STATUS_OFFLINE:
                $class = 'danger';
                $title = 'Offline';
                break;
            default:
                $class = 'default';
                $title = 'Unknown';
                break;
        };

        return (string) HTML::create('span', $title, [
            'class' => "label label-$class",
        ]);
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
}
