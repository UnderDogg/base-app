<?php

namespace App\Models\Traits;

use GrahamCampbell\Markdown\Facades\Markdown;

trait HasMarkdownTrait
{
    /**
     * Converts markdown to HTML.
     *
     * @param string $markdown
     *
     * @return string
     */
    public function fromMarkdown($markdown)
    {
        return Markdown::convertToHtml($markdown);
    }
}
