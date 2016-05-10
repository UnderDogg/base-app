<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;

class Label extends Model
{
    /**
     * The belongsToMany labels relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function issues()
    {
        return $this->belongsToMany(Issue::class, 'issue_labels');
    }

    /**
     * Returns the labels number of open issues.
     *
     * @return int
     */
    public function numberOfOpenIssues()
    {
        return $this->issues()->where('closed', false)->count();
    }

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
     * Returns an array of available label colors.
     *
     * @return array
     */
    public static function getColorsFormatted()
    {
        $colors = static::getColors();

        $formatted = [];

        foreach ($colors as $color) {
            $formatted[$color] = static::formatColorLabel($color);
        }

        return $formatted;
    }

    /**
     * The display attribute accessor.
     *
     * @return string
     */
    public function getDisplayAttribute()
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
    public function getDisplayLargeAttribute()
    {
        return HTML::create('span', $this->display, ['class' => 'label-large']);
    }

    /**
     * Returns the specified color as an HTML label.
     *
     * @param $color
     *
     * @return string
     */
    protected static function formatColorLabel($color)
    {
        $name = ucfirst($color);

        // Cast the raw HTML to string before giving it to the
        // array due to unintentional escaping of it's HTML.
        return (string) HTML::raw("<span class='label label-$color'>$name</span>");
    }
}
