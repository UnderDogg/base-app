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
     * Returns the default labels.
     *
     * @return array
     */
    public static function getDefault()
    {
        return [
            [
                'name' => 'Duplicate',
                'color' => 'default',
            ],
            [
                'name' => 'In Progress',
                'color' => 'info',
            ],
            [
                'name' => 'Question',
                'color' => 'info',
            ],
            [
                'name' => 'Working on it',
                'color' => 'warning',
            ],
            [
                'name' => 'Bug',
                'color' => 'danger',
            ],
            [
                'name' => 'Critical',
                'color' => 'danger',
            ],
        ];
    }

    /**
     * Displays the label in HTML.
     *
     * @return string
     */
    public function display()
    {
        $color = $this->color;

        return HTML::create('span', $this->name, ['class' => "label label-$color"]);
    }

    /**
     * Displays a large version of the HTML label.
     *
     * @return string
     */
    public function displayLarge()
    {
        return HTML::create('h4', $this->display());
    }
}
