<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    /**
     * The categories table.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The casted category attributes.
     *
     * @var array
     */
    protected $casts = ['options' => 'array'];

    /**
     * {@inheritdoc}
     */
    public function getLftName()
    {
        return 'lft';
    }

    /**
     * {@inheritdoc}
     */
    public function getRgtName()
    {
        return 'rgt';
    }

    /**
     * {@inheritdoc}
     */
    protected function getScopeAttributes()
    {
        return ['belongs_to'];
    }

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
        $query = static::whereIsRoot();

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
     * @param Category $category
     *
     * @return array
     */
    public static function getRenderedNode(Category $category)
    {
        $options = [];

        $name = static::getRenderedNodeName($category);

        $options[$category->id] = $name;

        if ($category->children()->count() > 0) {
            foreach ($category->children as $child) {
                $options = $options + static::getRenderedNode($child);
            }
        }

        return $options;
    }

    /**
     * Returns the specified rendered node name combined with its depth.
     *
     * @param Category $category
     * @param string   $separator
     *
     * @return string
     */
    public static function getRenderedNodeName(Category $category, $separator = '-')
    {
        if ($category->isRoot()) {
            $name = $category->name;
        } else {
            $depth = str_repeat($separator, $category->depth);

            $name = sprintf('%s %s', $depth, $category->name);
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
