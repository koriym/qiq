<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Textarea extends TagHelper
{
    /**
     * @param stringy-array $attr
     */
    public function __invoke(array $attr) : string
    {
        $text = $attr['value'] ?? '';
        assert(is_string($text));
        unset($attr['value']);
        return $this->fullTag('textarea', $attr, $text);
    }
}
