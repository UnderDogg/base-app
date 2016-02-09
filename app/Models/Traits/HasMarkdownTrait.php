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
        $markdown = Markdown::convertToHtml($markdown);

        $markdown = $this->highlightMentions($markdown);
        $markdown = $this->highlightHashTags($markdown);

        return $markdown;
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

    /**
     * Replaces each hash tag with a hash link.
     *
     * @param string $text
     *
     * @return string
     */
    public function highlightHashTags($text = '')
    {
        $replace = sprintf('$1<a href="%s/$3">$2$3</a>', url('hashtag'));

        return preg_replace(
            '/(^|[^0-9A-Z&\/\?]+)([#＃]+)([0-9A-Z_]*[A-Z_]+[a-z0-9_üÀ-ÖØ-öø-ÿ]*)/iu',
            $replace,
            $text
        );
    }
}
