<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class MetaName extends HtmlHelper
{
    public function __invoke(string $name, string $content) : string
    {
        return $this->voidTag('meta', [
            'name' => $name,
            'content' => $content,
        ]);
    }
}
