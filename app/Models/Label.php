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
     * The issue labels pivot table.
     *
     * @var string
     */
    protected $tablePivotLabels = 'issue_labels';

    /**
     * The belongsToMany labels relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function issues()
    {
        return $this->belongsToMany(Issue::class, $this->tablePivotLabels);
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
            'default'   => static::formatColorLabel('default'),
            'info'      => static::formatColorLabel('info'),
            'primary'   => static::formatColorLabel('primary'),
            'success'   => static::formatColorLabel('success'),
            'warning'   => static::formatColorLabel('warning'),
            'danger'    => static::formatColorLabel('danger'),
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
