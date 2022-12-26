<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class MetaHttp extends HtmlHelper
{
    public function __invoke(string $equiv, string $content) : string
    {
        return $this->voidTag('meta', [
            'http-equiv' => $equiv,
            'content' => $content,
        ]);
    }
}
