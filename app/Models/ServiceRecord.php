<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;

class ServiceRecord extends Model
{
    const STATUS_ONLINE = 1;
    const STATUS_DEGRADED = 2;
    const STATUS_OFFLINE = 3;

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
                break;
            case static::STATUS_DEGRADED:
                $class = 'warning';
                break;
            case static::STATUS_OFFLINE:
                $class = 'danger';
                break;
            default:
                $class = 'default';
                break;
        };

        return (string) HTML::create('span', $this->title, [
            'class' => "label label-$class",
        ]);
    }
}
