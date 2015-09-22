<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;

class Label extends Model
{
    /**
     * The labels table.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * Returns an array of available label colors.
     *
     * @return array
     */
    public static function getColors()
    {
        return [
            'default'   => 'default',
            'info'      => 'info',
            'primary'   => 'primary',
            'success'   => 'success',
            'warning'   => 'warning',
            'danger'    => 'danger',
        ];
    }

    /**
     * The display attribute accessor.
     *
     * @return string
     */
    public function getDisplayAttribute()
    {
        return (string) $this->getDisplay();
    }

    /**
     * Displays the label in HTML.
     *
     * @return string
     */
    public function getDisplay()
    {
        $color = $this->color;

        $name = HTML::entities($this->name);

        $icon = HTML::create('i', '', ['class' => 'fa fa-tag']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Displays a large version of the HTML label.
     *
     * @return string
     */
    public function getDisplayLarge()
    {
        return HTML::create('span', $this->getDisplay(), ['class' => 'label-large']);
    }
}
