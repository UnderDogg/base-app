<?php

namespace App\Models;

use App\Models\Traits\HasFilesTrait;
use App\Models\Traits\HasMarkdownTrait;
use App\Models\Traits\HasUserTrait;

class Patch extends Model
{
    use HasUserTrait;
    use HasFilesTrait;
    use HasMarkdownTrait;

    /**
     * The patch table.
     *
     * @var string
     */
    protected $table = 'patches';

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
        return $this->belongsToMany(Computer::class, 'patch_computers')->withPivot(['patched_at']);
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
