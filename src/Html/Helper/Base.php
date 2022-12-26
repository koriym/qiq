<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class Base extends HtmlHelper
{
    public function __invoke(string $href) : string
    {
        return $this->voidTag('base', ['href' => $href]);
    }
}
