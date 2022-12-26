<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

class Form extends HtmlHelper
{
    public function __invoke(array $attr = []) : string
    {
        $base = [
            'id' => null,
            'method' => 'post',
            'action' => null,
            'enctype' => 'multipart/form-data',
        ];

        $attr = array_merge($base, $attr);
        return $this->openTag('form', $attr);
    }
}
