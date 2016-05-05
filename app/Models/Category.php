<?php

namespace App\Models;

use Illuminate\Support\Arr;
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
     * @param string $belongsTo
     *
     * @return array
     */
    public static function getSelectHierarchy($belongsTo = null)
    {
        $roots = (new static())
            ->whereBelongsTo($belongsTo)
            ->whereIsRoot()
            ->with(['children'])
            ->get();

        $options = [null => 'None'];

        foreach ($roots as $root) {
            $options += static::getRenderedNode($root);
        }

        return $options;
    }

    /**
     * Renders the specified category and it's children in single dimension array.
     *
     * @param Category $category
     * @param int      $depth
     *
     * @return array
     */
    public static function getRenderedNode(Category $category, $depth = 0)
    {
        $options = [];

        $name = static::getRenderedNodeName($category, $depth);

        $options[$category->id] = $name;

        foreach ($category->children as $child) {
            $options += static::getRenderedNode($child, ++$depth);
        }

        return $options;
    }

    /**
     * Returns the specified rendered node name combined with its depth.
     *
     * @param Category $category
     * @param int      $depth
     * @param string   $separator
     *
     * @return string
     */
    public static function getRenderedNodeName(Category $category, $depth, $separator = '-')
    {
        if ($category->isRoot()) {
            return $category->name;
        }

        $depth = str_repeat($separator, $depth);

        return "$depth $category->name";
    }

    /**
     * Returns the manager required option.
     *
     * @return bool
     */
    public function getManagerAttribute()
    {
        return Arr::has($this->options, 'manager') ?
            Arr::get($this->options, 'manager') == true : false;
    }
}
