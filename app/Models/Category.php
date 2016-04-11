<?php

namespace App\Models;

use Baum\Node;

class Category extends Node
{
    /**
     * The categories table.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The scoped nested set attributes.
     *
     * @var array
     */
    protected $scoped = ['belongs_to'];

    /**
     * The casted category attributes.
     *
     * @var array
     */
    protected $casts = ['options' => 'array'];

    /**
     * Returns the complete nested set table in a nested list.
     *
     * @param string       $belongsTo
     * @param array        $except
     * @param array|string $first
     *
     * @return array
     */
    public static function getSelectHierarchy($belongsTo = null, array $except = [], $first = 'None')
    {
        $query = static::roots();

        if (!is_null($belongsTo)) {
            $query->whereBelongsTo($belongsTo);
        }

        $roots = $query->with(['children' => function ($query) use ($except) {
            return $query->whereNotIn('id', $except);
        }])->whereNotIn('id', $except)->get();

        if (is_array($first)) {
            $options[key($first)] = $first[key($first)];
        } else {
            $options = [null => $first];
        }

        foreach ($roots as $root) {
            $options = $options + static::getRenderedNode($root);
        }

        return $options;
    }

    /**
     * Renders the specified category and it's children in single dimension array.
     *
     * @param Node $node
     *
     * @return array
     */
    public static function getRenderedNode(Node $node)
    {
        $options = [];

        $name = static::getRenderedNodeName($node);

        $options[$node->id] = $name;

        if ($node->children()->count() > 0) {
            foreach ($node->children as $child) {
                $options = $options + static::getRenderedNode($child);
            }
        }

        return $options;
    }

    /**
     * Returns the specified rendered node name combined with its depth.
     *
     * @param Node   $node
     * @param string $separator
     *
     * @return string
     */
    public static function getRenderedNodeName(Node $node, $separator = '-')
    {
        if ($node->isRoot()) {
            $name = $node->name;
        } else {
            $depth = str_repeat($separator, $node->depth);

            $name = sprintf('%s %s', $depth, $node->name);
        }

        return $name;
    }

    /**
     * Returns the manager required option.
     *
     * @return bool
     */
    public function getManagerAttribute()
    {
        if (is_array($this->options) && array_key_exists('manager', $this->options)) {
            return $this->options['manager'] === true;
        }

        return false;
    }
}
