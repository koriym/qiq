<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class Meta extends HtmlHelper
{
    public function __invoke(array $attr) : string
    {
        return $this->voidTag('meta', $attr);
    }
}
