<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Base extends HtmlHelper
{
    public function __invoke(string $href) : string
    {
        return $this->voidTag('base', ['href' => $href]);
    }
}
