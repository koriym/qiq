<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Meta extends HtmlHelper
{
    public function __invoke(array $attr) : string
    {
        return $this->voidTag('meta', $attr);
    }
}
