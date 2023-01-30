<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Label extends TagHelper
{
    /**
     * @param array<string, string|string[]> $attr
     */
    public function __invoke(string $text, array $attr = []) : string
    {
        return $this->fullTag('label', $attr, $text);
    }
}
