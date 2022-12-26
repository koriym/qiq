<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class Anchor extends HtmlHelper
{
    public function __invoke(string $href, string $text, array $attr = []) : string
    {
        $base = [
            'href' => $href,
        ];

        unset($attr['href']);

        $attr = array_merge($base, $attr);
        return $this->fullTag('a', $attr, $text);
    }
}
