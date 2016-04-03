<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use Orchestra\Support\Facades\HTML;

class ServiceRecord extends Model
{
    const STATUS_ONLINE = 1;
    const STATUS_DEGRADED = 2;
    const STATUS_OFFLINE = 3;
    const STATUS_UNKNOWN = 4;

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
        return (string) HTML::create('span', $this->title, [
            'class' => "label label-$this->color",
        ]);
    }

    /**
     * The service record status title accessor.
     *
     * @return string
     */
    public function getStatusTitleAttribute()
    {
        switch ($this->status) {
            case static::STATUS_ONLINE:
                $title = 'Online';
                break;
            case static::STATUS_DEGRADED:
                $title = 'Degraded';
                break;
            case static::STATUS_OFFLINE:
                $title = 'Offline';
                break;
            default:
                $title = 'Unknown';
                break;
        }

        return $title;
    }

    /**
     * The service record status color accessor.
     *
     * @return string
     */
    public function getColorAttribute()
    {
        switch ($this->status) {
            case static::STATUS_ONLINE:
                $color = 'success';
                break;
            case static::STATUS_DEGRADED:
                $color = 'warning';
                break;
            case static::STATUS_OFFLINE:
                $color = 'danger';
                break;
            default:
                $color = 'default';
                break;
        }

        return $color;
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
