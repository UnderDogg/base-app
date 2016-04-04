<?php

namespace App\Models;

use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;
use App\Traits\CanPurifyTrait;

class Patch extends Model
{
    use HasUserTrait, HasMarkdownTrait, CanPurifyTrait;

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
        return $this->belongsToMany(Computer::class, $this->tableComputersPivot)->withPivot(['patched_at']);
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

    /**
     * Accessor for the tag line of the patch.
     *
     * @return string
     */
    public function getTagLineAttribute()
    {
        $user = $this->user->name;

        $daysAgo = $this->created_at_human;

        $computers = count($this->computers);

        $icon = '<i class="fa fa-desktop"></i>';

        $hash = $this->hash_id;

        $comments = "<span class='pull-right hidden-xs'>$icon $computers</span>";

        return "$hash created $daysAgo by $user $comments";
    }
}
