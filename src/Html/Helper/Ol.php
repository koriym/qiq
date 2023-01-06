<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

use Qiq\Indent;

class Ol extends Items
{
    public function __invoke(array $items, array $attr = []) : string
    {
        $this->indent->level(+1);
        $list = $this->items($items);
        $this->indent->level(-1);

        if ($list === '') {
            return '';
        }

        return $this->openTag('ol', $attr) . PHP_EOL
            . $list
            . $this->indent->get() . '</ol>';
    }
}