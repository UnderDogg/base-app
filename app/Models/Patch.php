<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Traits\CanPurifyTrait;

class Patch extends Model
{
    use HasMarkdownTrait, CanPurifyTrait;

    /**
     * The patch table.
     *
     * @var string
     */
    protected $table = 'patches';

    /**
     * The computers patch pivot table.
     *
     * @var string
     */
    protected $tableComputersPivot = 'patch_computers';

    /**
     * The fillable computer patch attributes.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The belongsToMany computers relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function computers()
    {
        return $this->belongsToMany(Computer::class, $this->tableComputersPivot);
    }

    /**
     * Sets the issue's description attribute.
     *
     * @param string $description
     */
    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = $this->clean($description);
    }

    /**
     * Returns the description from markdown to HTML.
     *
     * @return string
     */
    public function getDescriptionFromMarkdownAttribute()
    {
        return $this->fromMarkdown($this->description);
    }
}
