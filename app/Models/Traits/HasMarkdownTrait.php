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

    /**
     * Replaces each mention with a link to the user.
     *
     * @param string $text
     *
     * @return string
     */
    public function highlightMentions($text = '')
    {
        $url = url('users');

        $replace = sprintf('$1<a href="%s/$2">@$2</a>', $url);

        return preg_replace('/(^|[^a-z0-9_])@([a-z0-9_]+)/i', $replace, $text);
    }
}
