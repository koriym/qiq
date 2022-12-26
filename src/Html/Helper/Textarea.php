<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class Textarea extends HtmlHelper
{
    public function __invoke(array $attr) : string
    {
        $text = $attr['value'] ?? '';
        unset($attr['value']);
        return $this->fullTag('textarea', $attr, $text);
    }
}
