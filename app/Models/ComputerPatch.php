<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Traits\CanPurifyTrait;

class ComputerPatch extends Model
{
    use HasMarkdownTrait, CanPurifyTrait;

    /**
     * The computer patch table.
     *
     * @var string
     */
    protected $table = 'computer_patches';

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
     * The belongsTo computer relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function computer()
    {
        return $this->belongsTo(Computer::class);
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
