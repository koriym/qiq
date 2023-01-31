<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

class Script extends TagHelper
{
    /**
     * @param stringy-array $attr
     */
    public function __invoke(string $src, array $attr = []) : string
    {
        $base = [
            'src' => $src,
            'type' => 'text/javascript'
        ];
        unset($attr['src']);
        $attr = array_merge($base, $attr);
        return $this->fullTag('script', $attr);
    }
}
