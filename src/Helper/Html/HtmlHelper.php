<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

abstract class HtmlHelper
{
    public function __construct(
        protected Escape $escape,
        protected Indent $indent,
    ) {
    }

    protected function openTag(string $tag, array $attr) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->escape->a($attr);
        return trim("<{$tag} {$attr}") . ">";
    }

    protected function fullTag(string $tag, array $attr, string $text = '') : string
    {
        $raw = $attr['_raw'] ?? false;
        unset($attr['_raw']);

        if (! $raw) {
            $text = $this->escape->h($text);
        }

        return $this->openTag($tag, $attr) . $text . "</{$tag}>";
    }

    protected function voidTag(string $tag, array $attr) : string
    {
        $tag = $this->escape->a($tag);
        $attr = $this->escape->a($attr);
        return trim("<{$tag} {$attr}") . " />";
    }
}
